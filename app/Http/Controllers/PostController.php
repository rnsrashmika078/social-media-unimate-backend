<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('postedBy' , 'likes')->get();
        return response()->json([
            'posts' => $posts
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string|max:255',
            'friend_id' => 'required',
        ]);
        $posts = Post::create($validatedData);
        return response()->json([
            'message' => 'post created succesfully!',
            'status' => 'success',
            'data' => $posts,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
    public function toggleLike($post_id, $friend_id)
    {
        try {
            $post = Post::findOrFail($post_id);
            $friend = Post::findOrFail($friend_id);

            $alreadyLiked = $post->likes()->where('friend_id', $friend_id)->exists();

            $post->likes()->toggle($friend_id);
            return response()->json([
                'message' => !$alreadyLiked ?  "you have liked the post {$post_id}" : "you have disliked the post {$post_id}",
                'likes_count' => $post->likes()->count(),
                'liked' => $post->likes()->where('friend_id', $friend_id)->exists()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => "something went wrong {$e}",
                'error' => $e->getMessage()
            ]);
        }
    }
}
