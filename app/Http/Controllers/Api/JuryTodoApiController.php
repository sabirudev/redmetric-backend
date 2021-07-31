<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class JuryTodoApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Submission $todos)
    {
        $todos = $todos
            ->selectRaw('submissions.*,
            periods.opened,
            periods.closed,
            jury_submissions.submission_id,
            jury_submissions.jury_id,
            jury_submissions.total_points as jury_total_points,
            villages.name as village_name,
            users.email as user_email')
            ->join('periods', 'submissions.period_id', '=', 'periods.id')
            ->join('users', 'submissions.user_id', '=', 'users.id')
            ->join('villages', 'villages.user_id', '=', 'users.id')
            ->leftJoin('jury_submissions', 'jury_submissions.submission_id', '=', 'submissions.id')
            ->where('jury_submissions.jury_id', '<>', $request->user()->jury->id)
            ->where('submissions.publish', 1)
            ->paginate();
        return response()->success($todos);
    }

    public function mylist(Request $request)
    {
        return response()->success($request->user()->load('jury.submissions'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $todo)
    {
        return response()->json($todo->load([
            'user',
            'period',
            'indicators'
        ]));
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
