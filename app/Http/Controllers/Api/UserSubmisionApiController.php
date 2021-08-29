<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Submission;
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

    public function all(Request $request, Submission $submissions)
    {
        $submissions = $submissions->with([
            'user.village',
            'period'
        ]);
        $submissions = $this->handleFilterKeyword($request, $submissions);
        return response()->success($submissions->paginate());
    }

    private function handleFilterKeyword(Request $request, $submissions)
    {
        $submissions = $submissions->when($request->filled('s'), function ($query) use ($request) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->whereHas('user', function ($a) use ($request) {
                    $a->where('email', 'like', '%' . $request->s . '%')
                        ->orWhereHas('village', function ($b) use ($request) {
                            $b->where('name', 'like', '%' . $request->s . '%');
                        });
                });
            });
        });
        return $submissions;
    }
}
