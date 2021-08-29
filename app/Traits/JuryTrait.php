<?php

namespace App\Traits;

use App\Models\Submission;
use Illuminate\Http\Request;

/**
 * 
 */
trait JuryTrait
{
    public function jurySubmission(Submission $submissions, Request $request, $page = null)
    {
        $submissions = $submissions->load([
            'user.village',
            'period',
            'indicators' => function ($query) use ($page) {
                $query->where('indicator_criteria_id', $page);
            },
            'indicators.inputs'
        ]);
        $submissions = collect($submissions->indicators)->map(function ($indicator) use ($request) {
            $indicator->pivot->load([
                'juryValues' => function ($query) use ($request) {
                    $query->where('jury_id', $request->user()->jury->id);
                },
                'evidence'
            ]);
            return $indicator;
        });
        return $submissions;
    }
}
