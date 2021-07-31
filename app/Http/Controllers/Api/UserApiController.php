<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterUsers;
use App\Http\Requests\UserStore;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FilterUsers $request, User $users)
    {
        $users = $this->handleFilterUserRole($request, $users);
        $users = $this->handleFilterSearch($request, $users);
        $users = $users->paginate();
        return response()->success($users);
    }

    private function handleFilterSearch(Request $request, $users)
    {
        if ($request->has('s')) {
            $users = $users->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->s . '%')
                    ->orWhere('email', 'like', '%' . $request->s . '%')
                    ->orWhereHas('membership', function ($subQuery) use ($request) {
                        $subQuery->where('phone', $request->s);
                    })
                    ->orWhereHas('village', function ($subQuery) use ($request) {
                        $subQuery->where('name', 'like', '%' . $request->s . '%');
                    });
            });
        }
        return $users;
    }

    private function handleFilterUserRole(Request $request, $users)
    {
        if ($request->has('r')) {
            switch ($request->r) {
                case '2':
                    $users = $users->with(['membership', 'village']);

                    break;

                default:
                    $users = $users->with(['membership']);
                    $users = $users->where('role_id', $request->r);
                    break;
            }
        }
        return $users;
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
    public function store(UserStore $request, User $user)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = bcrypt($request->password);
        $data['role_id'] = $request->role_id;
        $user = $user->create($data);
        if ($user) {
            if (intval($request->role_id) === 3) {
                $user->jury()->create([
                    'phone' => '+62',
                    'title' => '-',
                    'position' => '-'
                ]);
            }
            $user->membership()->create([
                'uuid' => time()
            ]);
            return response()->success($user->load('membership'));
        } else {
            return response()->fail([
                'errors' => [
                    'Failed to create new user'
                ]
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = $user->role_id == 2
            ? $user->load(['village', 'membership'])
            : $user->load('membership');
        return response()->success($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, User $user)
    {
        $data['name'] = $request->name;
        if ($request->has('email')) {
            $data['email'] = $request->email;
        }
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->has('role_id')) {
            $data['role_id'] = $request->role_id;
        }
        if ($user->update($data)) {
            $user = $user->role_id == 2
                ? $user->load(['village', 'membership'])
                : $user->load('membership');
            return response()->success($user);
        } else {
            return response()->fail([
                'errors' => [
                    'Failed to update user'
                ]
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
