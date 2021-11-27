<?php

namespace App\Http\Controllers;

use App\Models\IndicatorCriteria;
use App\Models\Period;
use App\Models\Submission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmissionController extends Controller
{
    public function form(Request $request, Period $period)
    {
        $pivot = collect([]);
        $submission = Submission::with('indicators')
            ->where('user_id', $request->user()->id)
            ->where('period_id', $period->id)
            ->first();
        if ($submission) {
            $pivot = $submission->indicators->map(function ($indicator) {
                return $indicator->pivot->load([
                    'values',
                    'evidence'
                ]);
            });
        }


        $categories     = IndicatorCriteria::with(['indicators.inputs'])->get();
        $questions      = $categories->mapWithKeys(function ($criteria) use ($pivot) {
            $items = $criteria->indicators->map(function ($indicator) {
                return $indicator->inputs->load('indicator');
            })->flatten();
            $items = $items->map(function ($item, $index) use ($pivot) {
                $input      = $pivot->pluck('values')->flatten()->where('indicator_input_id', $item->id)->first();
                $question   = collect($item);
                $loadPivot  = collect($pivot->where('indicator_id', $question->get('indicator_id'))->first());
                $loadPivot->forget('values');
                $question   = $question->merge([
                    'index' => $index,
                    'value' => $input->value ?? null,
                    'pivot' => $loadPivot
                ]);
                return $question;
            });
            return [$criteria->id => $items];
        });
        $steps = $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'title' => "Step {$category->id}",
                'subtitle' => $category->name,
                'active' => $category->id === 1
            ];
        });
        return Inertia::render('SubmissionForm', [
            'questions' => $questions,
            'period' => $period,
            'steps' => $steps,
        ]);
    }

    public function store(Request $request)
    {
        # code...
    }
}
