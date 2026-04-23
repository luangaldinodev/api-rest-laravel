<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentPage = $request->query('current_page') ?? 1;
        $regsPerPage = 3;
        $skip = ($currentPage - 1) * $regsPerPage;
        
        $users = User::skip($skip)->take($regsPerPage)->orderByDesc('id')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            
            $user = User::create($request->validated());

            return response()->json($user, 201);

        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error creating user.",
                "status" => 400,
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            
            $user = User::findOrFail($id);

            return response()->json($user);

        } catch (\Exception $ex) {
            return response()->json([
                "message" => "User not found",
                "status" => 404,
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            
            $user = User::findOrFail($id);

            $user->update($request->validated());

            return response()->json($user, 200);

        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error updating user.",
                "status" => 400
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            
            $user = User::findOrFail($id)->delete();

            return response()->json($user, 200);

        } catch (\Exception $ex) {
            return response()->json([
                "message" => "Error deleting user.",
                "status" => 400
            ], 400);
        }
    }
}
