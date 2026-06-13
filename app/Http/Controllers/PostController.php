<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComments;
use App\Models\PostLikes;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function likePost($post_id, $user_id)
    {

        // $user = auth()->user();

        // $user->likedPosts()->attach($id);
        $data = [
            'post_id' => $post_id,
            'user_id' => $user_id
        ];
        PostLikes::create($data);

        return response()->json([
            'message' => 'You have liked this post',
        ]);
    }
    public function commentPost(Request $request, $post_id, $user_id)
    {
     
        $data = [
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment' => $request->comment
        ];
        PostComments::create($data);

        return response()->json([
            'message' => 'You have Commented on this post',
        ]);
    }
    public function getPosts($id)
    {

        $allPosts = Post::with(['user', 'likedPosts', 'commentPosts'])
            ->where('user_id', $id)
            ->get();
        return response()->json([
            'message' => 'Retrived all posts successfully!',
            'post' => $allPosts,
        ]);
    }
    public function addPost(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
            'attachment' => 'required',
            'user_id' => 'required'

        ]);
        $post = Post::create($data);

        return response()->json([
            'message' => 'Post added successfully!',
            'post' => $post,
        ]);
    }
    public function updatePost(Request $request, $id)
    {
        $data = $request->validate([
            'content' => 'nullable|string',
            'attachment' => 'nullable'
        ]);

        $post = Post::findOrFail($id);

        $post->update($data);

        return response()->json([
            'message' => 'Post updated successfully!',
            'post' => $post
        ]);
    }
    public function deletePost($id)
    {
        Post::where('id', $id)->delete();
        return response()->json([
            'message' => 'Post deleted successfully!',
        ]);
    }
}
