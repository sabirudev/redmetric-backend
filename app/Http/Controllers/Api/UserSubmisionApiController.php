<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSubmisionApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->success($request->user()->load('submissions.period'));
    }
}
