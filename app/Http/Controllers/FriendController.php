<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class FriendController extends Controller
{

    public function index()
    {
        $friends = Friend::with('posts', 'post_likes')->get();
        return response()->json([
            'friends' => $friends
        ]);
    }

    public function create() {}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'string',
            'address' => 'string',
            'email' => 'string',
            'username' => 'string',
            'dp' => 'string',
            'title' => 'string',
        ]);
        $user = Friend::create($validatedData);
        return response()->json([
            'message' => 'user created successfully!',
            'status' => 'success',
            'data' => $user,
        ], 201);
    }

    public function show(string $id) {}

    public function edit(string $id) {}


    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
