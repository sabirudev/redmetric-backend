<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

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

    public function submission()
    {
        return Inertia::render('Submission');
    }
}
