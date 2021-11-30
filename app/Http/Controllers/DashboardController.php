<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Mockery\Matcher\Subset;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = collect($request->user()->load(['membership.identities', 'village']));
        return Inertia::render('Dashboard', [
            'membership' => $user->get('membership'),
            'village' => $user->get('village')
        ]);
    }

    public function submission(Request $request, Period $periods)
    {
        $periods = $periods
        ->where('is_ended', false)
        ->with([
            'submissions' => function($query) use($request){
                $query->where('user_id', $request->user()->id);
            }
        ])
        ->orderBy('created_at', 'desc')
        ->get();
        $submissions = $periods->map(function($period){
            return collect($period)->merge([
                'submissions' => collect($period->submissions)->first()
            ]);
        });
        return Inertia::render('Submission', ['submissions' => $submissions]);
    }
}
