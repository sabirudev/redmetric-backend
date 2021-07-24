<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Period $periods)
    {
        $periods = $periods->withCount('submissions');
        $periods = $this->handleFilterSearch($request, $periods);
        $periods = $periods->paginate();
        return response()->success($periods);
    }

    private function handleFilterSearch(Request $request, $periods)
    {
        if ($request->has('s')) {
            $periods->where(function ($query) use ($request) {
                $query->where('opened', 'like', $request->s)
                    ->orWhere('closed', 'like', $request->s);
            });
        }
        return $periods;
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
    public function store(Request $request, Period $period)
    {
        $period = $period->create($request->all());
        if ($period) {
            return response()->success($period);
        } else {
            return response()->fail($period);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function show(Period $period)
    {
        return response()->success($period);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Period $period)
    {
        $period->update($request->all());
        return response()->success($period);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Period  $period
     * @return \Illuminate\Http\Response
     */
    public function destroy(Period $period)
    {
        if ($period->submissions->count() > 0) {
            return response()->fail([
                'period' => $period,
                'message' => 'Failed ! Period has submissions'
            ]);
        } else {
            $period->delete();
            return response()->success($period);
        }
    }
}
