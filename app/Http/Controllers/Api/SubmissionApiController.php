<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EvidenceStore;
use App\Http\Requests\SubmissionStore;
use App\Models\IndicatorCriteria;
use App\Models\IndicatorSubmission;
use App\Models\Period;
use App\Models\Submission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, IndicatorCriteria $criteria)
    {
        $activePeriod = Period::where(function ($query) {
            $query->whereDate('opened', '<=', Carbon::now()->format('Y-m-d'))
                ->whereDate('closed', '>=', Carbon::now()->format('Y-m-d'))
                ->where('is_ended', false);
        })
            ->first();
        if ($activePeriod) {
            $pivot = collect([]);
            $submission = Submission::with('indicators')
                ->where('user_id', $request->user()->id)
                ->where('period_id', $activePeriod->id)
                ->first();
            if ($submission) {
                $pivot = $submission->indicators->map(function ($indicator) {
                    return $indicator->pivot->load([
                        'values',
                        'evidence'
                    ]);
                });
            }
            $idCriteria = $request->page ?? 1;
            $idCriteria = $idCriteria == 0 ? 1 : $idCriteria;
            $criteria = $criteria->with([
                'indicators.inputs'
            ]);
            $criteria   = $criteria->where('id', $idCriteria)->first();
            $questions  = $criteria->indicators->map(function ($indicator) {
                return $indicator->inputs->load('indicator');
            })->flatten();
            $questions  = $questions->map(function ($question, $index) use ($pivot) {
                $input      = $pivot->pluck('values')->flatten()->where('indicator_input_id', $question->id)->first();
                $question   = collect($question);
                $loadPivot  = collect($pivot->where('indicator_id', $question->get('indicator_id'))->first());
                $loadPivot->forget('values');
                $question   = $question->merge([
                    'index' => $index,
                    'value' => $input->value ?? null,
                    'pivot' => $loadPivot
                ]);
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
        $response = $submission->load([
            'indicators' => function ($query) use ($request) {
                $query->when($request->code, function ($q) use ($request) {
                    return $q->where('code', $request->code);
                });
            }
        ]);
        $page = intval($request->page ?? 1);
        $response = collect([
            'next' => $page + 1,
            'prev' => $page - 1,
            'current' => $page
        ])->merge($response);
        return response()->success($response);
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
                return collect(['*', '+', '/', '(', ')'])->contains($config)
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
        $submission->publish = 1;
        $submission->save();
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

    public function evidence(EvidenceStore $request, IndicatorSubmission $submit)
    {
        if ($request->hasFile('file')) {
            if ($submit->evidence()->count() > 0) {
                Storage::disk('public')->delete($submit->evidence->file);
                $submit->evidence()->delete();
            }

            if ($submit->evidence()->count() === 0) {
                $submit->evidence()->create([
                    'name' => $submit->indicator->code ?? 'submit-' . $submit->id,
                    'file' => $request->file->store('evidences', 'public')
                ]);
            }
        }
        return response()->success($submit->load('evidence'));
    }
}
