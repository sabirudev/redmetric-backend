<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VillageStore;
use App\Http\Requests\VillageUpdate;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->success($request->user()->load([
            'village',
            'membership'
        ]));
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
    public function store(VillageStore $request, Village $village)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $village = $village->create($data);
        if ($village) {
            return response()->success($village->load('account.membership'));
        } else {
            return response()->fail([
                'message' => 'Error! failed to store village'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(Village $village)
    {
        return response()->success($village->load('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function edit(Village $village)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(VillageUpdate $request, Village $village)
    {
        $village->update($request->all());
        return response()->success($village->load('account.membership'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy(Village $village)
    {
        //
    }
}
