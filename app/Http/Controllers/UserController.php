<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, UserService $userService)
    {
        $query = $userService->searchUsers($request->get('keyword'));
        $sortBy = $request->get('sortBy', 'name');
        $sortDirection = $request->get('sortDirection', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, UserService $userService): Response
    {
        $user = $userService->createUser($request->only(['name', 'email', 'password']), $request->get('emailPassword', false));

        return response($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user): Response
    {
        return  response($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user, UserService $userService)
    {
        $user = $userService->updateUser($user, $request->only(['name', 'email', 'password']), $request->get('emailPassword', false));

        return response($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserService $userService): Response
    {
        $userService->deleteUser($user);

        return response('', Response::HTTP_NO_CONTENT);
    }
}
