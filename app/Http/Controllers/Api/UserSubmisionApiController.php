<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserSubmisionApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->success($request->user()->load('submissions.period'));
    }

    public function show(Attachment $uploaded)
    {

        if (Storage::disk('public')->exists($uploaded->file)) {
            return response()->file(public_path(Storage::url($uploaded->file)));
        } else {
            return response()->fail([
                'errors' => [
                    'File doesn\'t exist'
                ]
            ], 404);
        }
    }
}
