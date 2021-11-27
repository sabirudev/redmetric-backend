<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Mockery\Matcher\Subset;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = collect($request->user()->load(['membership', 'village']));
        return Inertia::render('Dashboard', [
            'membership' => $user->get('membership'),
            'village' => $user->get('village')
        ]);
    }

    public function submission(Request $request, Submission $submissions)
    {
        $submissions = $submissions::where('user_id', $request->user()->id)
            ->with('period')
            ->get();
        return Inertia::render('Submission', ['submissions' => $submissions]);
    }
}
