<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionStore;
use App\Models\IndicatorCriteria;
use App\Models\Submission;
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
        $idCriteria = $request->page ?? 1;
        $criteria = $criteria->with([
            'indicators.inputs'
        ]);
        $criteria = $criteria->where('id', $idCriteria)->get();
        return response()->success($criteria);
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
        //
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
        //
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
