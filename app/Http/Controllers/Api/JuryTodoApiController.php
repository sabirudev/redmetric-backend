<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoStore;
use App\Models\JurySubmission;
use App\Models\Submission;
use App\Traits\JuryTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class JuryTodoApiController extends Controller
{
    use JuryTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Submission $todos)
    {
        $todos = $todos->with([
            'user.village',
            'period'
        ]);
        $todos = $todos->where('publish', 1);
        $todos = $todos->whereDoesntHave('jurySubmissions', function ($query) use ($request) {
            $query->where('jury_id', $request->user()->jury->id);
        });
        $todos = $todos->paginate()->setPath('');
        return response()->success($todos);
    }

    public function mylist(Request $request)
    {
        $submissions = $request->user()->jury->submissions->load([
            'submission.period',
            'submission.user.village'
        ]);

        return response()->success($this->paginate($submissions));
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
    public function store(TodoStore $request, Submission $submission)
    {
        DB::beginTransaction();
        try {
            JurySubmission::firstOrCreate(
                [
                    'submission_id' => $request->submission_id,
                    'jury_id' => $request->user()->jury->id
                ]
            );
            collect($request->submissions)->each(function ($item) use ($request) {
                $fields = collect($item);
                $fields = $fields->merge([
                    'jury_id' => $request->user()->jury->id
                ]);
                DB::table('jury_indicator_submissions')->updateOrInsert(
                    $fields->only(['jury_id', 'indicator_submission_id'])->toArray(),
                    $fields->only(['point'])->toArray()
                );
            });
            DB::commit();
            $submission = $submission->where('id', $request->submission_id)->first();
            $submission = $this->jurySubmission($submission, $request, $request->page ?? 1);
            return response()->success($submission);
        } catch (\Throwable $th) {
            throw $th;
            DB::rollBack();
            return response()->fail([
                'errors' => [
                    'All points failed to store'
                ]
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Submission $todo)
    {
        $page = $request->page ?? 1;
        $todos = $this->jurySubmission($todo, $request, $page);
        return response()->json($todos);
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
    public function update(Request $request, JurySubmission $todo)
    {
        $todos = collect($todo->submission->indicators)->map(function ($indicator) use ($request) {
            $indicator->pivot->load([
                'juryValues' => function ($query) use ($request) {
                    $query->where('jury_id', $request->user()->jury->id);
                }
            ]);
            return $indicator->pivot->juryValues->first();
        });
        $todo->total_points = $todos->sum('point');
        if ($request->filled('note')) {
            $todo->note = $request->note;
        }
        $todo->save();
        return response()->success($todo);
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
