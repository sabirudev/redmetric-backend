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
            if ($village->account()->count() > 0) {
                $user = $village->account;
                return response()->success($user->load([
                    'village',
                    'membership'
                ]));
            } else {
                return response()->fail($village, 404);
            }
        } else {
            return response()->fail([
                'message' => 'Error! failed to store village'
            ], 500);
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
        if ($village->account()->count() > 0) {
            $user = $village->account;
            return response()->success($user->load([
                'village',
                'membership'
            ]));
        } else {
            return response()->fail($village, 404);
        }
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
        $village->update($request->except([
            'id',
            'user_id'
        ]));
        if ($village->account()->count() > 0) {
            $user = $village->account;
            return response()->success($user->load([
                'village',
                'membership'
            ]));
        } else {
            return response()->fail($village, 404);
        }
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
