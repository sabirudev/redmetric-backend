<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionStore;
use App\Models\IndicatorCriteria;
use App\Models\Period;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubmissionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, IndicatorCriteria $criteria)
    {
        $activePeriod = Period::whereDate('opened', '<=', Carbon::now()->format('Y-m-d'))
            ->whereDate('closed', '>=', Carbon::now()->format('Y-m-d'))
            ->where('is_ended', false)
            ->first();
        if ($activePeriod) {
            $values = collect([]);
            $submission = Submission::with('indicators')
                ->where('user_id', $request->user()->id)
                ->where('period_id', $activePeriod->id)
                ->first();
            if ($submission) {
                $values = $submission->indicators->map(function ($indicator) {
                    return $indicator->pivot->values ?? [];
                })->flatten();
            }
            $idCriteria = $request->page ?? 1;
            $criteria = $criteria->with([
                'indicators.inputs'
            ]);
            $criteria   = $criteria->where('id', $idCriteria)->first();
            $questions  = $criteria->indicators->map(function ($indicator) {
                return $indicator->inputs->load('indicator');
            })->flatten();
            $questions  = $questions->map(function ($question) use ($values) {
                $value      = $values->filter(function ($value) use ($question) {
                    return $value->indicator_input_id === $question->id;
                })->first()->value ?? null;
                $question   = collect($question);
                $question   = $question->merge(['value' => $value]);
                return $question;
            });
            return response()->success($questions);
        } else {
            return response()->fail([
                'errors' => 'Sorry, period is over'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubmissionStore $request, Submission $submission)
    {
        $submission = $submission->firstOrCreate([
            'user_id' => $request->user()->id,
            'period_id' => $request->period_id,
        ]);
        $indicators = collect($request->submissions)->groupBy('indicator_id');
        $submission->indicators()->syncWithoutDetaching($indicators->keys()->toArray());
        $submission->indicators->each(function ($indicator) use ($indicators) {
            $values = $indicators->get($indicator->id);
            if ($values) {
                $values = $values->map(function ($value) {
                    return [
                        'indicator_input_id' => $value['indicator_input_id'],
                        'value' => $value['value']
                    ];
                });

                if ($indicator->pivot->values()->count() > 0) {
                    $indicator->pivot->values()->whereIn('indicator_input_id', $values->pluck('indicator_input_id')->toArray())->delete();
                }
                $indicator->pivot->values()->createMany($values->toArray());
            }
        });
        return response()->success($submission);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        return response()->success($submission);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {
        $configFramework = config('redmetric-framework');
        $user = $submission->user;
        $results = $submission->indicators->map(function ($indicator) use ($configFramework, $user) {
            $userDetails = collect($user->load('village'));
            $values = collect($indicator->pivot->values ?? [])->pluck('value');
            $formula = collect($configFramework[$indicator->code] ?? [])->map(function ($config, $key) use ($values, $userDetails) {
                return collect(['*', '+', '/'])->contains($config)
                    ? $config
                    : $values[$config] ?? data_get($userDetails, $config, null) ?? $config;
            });
            $result = $formula->join('');
            $result = number_format(eval("return $result;"), 2);
            $indicator->pivot->update([
                'result' => $result
            ]);
            return [
                'code' => $indicator->code,
                'formula' => $formula,
                'values' => $values,
                'result' => $result,
                'indicator_result' => data_get(collect($indicator->pivot), 'result', null)
            ];
        });
        return response()->success($results);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        //
    }
}
