<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComments;
use App\Models\PostLikes;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{


    public function likePost($post_id, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            if ($user->likedPosts()->where('post_id', $post_id)->exists()) {
                $user->likedPosts()->detach($post_id);
                return response()->json([
                    'message' => 'You have disliked this post',
                    'isLike' => false

                ]);
            }

            // if (!$user->likedPosts()->where('post_id', $post_id)->exists()) {
            //     $user->likedPosts()->attach($post_id);
            // }

            $user->likedPosts()->attach($post_id);
            return response()->json([
                'message' => 'You have liked this post',
                'isLike' => true
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getLikeByPostId($post_id)
    {
        try {
            $likes = Post::with('likedByUsers')->findOrFail($post_id);

            return response()->json([
                'message' => 'get likes user of this post',
                'likes' => $likes
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function commentPost(Request $request, $post_id, $user_id)
    {
        try {
            $request->validate([
                'comment' => 'required|string'
            ]);

            $post = Post::findOrFail($post_id);

            PostComments::create([
                'post_id' => $post->id,
                'user_id' => $user_id,
                'comment' => $request->comment
            ]);

            return response()->json([
                'message' => 'You have Commented on this post',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getCommentByPostId($post_id)
    {
        try {

            $comments = PostComments::with(['user'])->where('post_id', $post_id)->get();
            return response()->json([
                'message' => 'all comments are received belong to the post',
                'comments' => $comments
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getPostsByMe($id)
    {

        try {
            $allPosts = Post::with(['user', 'likedByUsers', 'comments.user'])
                ->where('user_id', $id)
                ->get();
            return response()->json([
                'message' => 'Retried all posts successfully!',
                'post' => $allPosts,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function getPosts()
    {
        try {
            $allPosts = Post::with(['user'])->withCount('comments', 'likedByUsers')
                ->get();
            return response()->json([
                'message' => 'Retrieved all posts successfully!',
                'post' => $allPosts,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
        // comments in user and user in PostComments

    }
    public function addPost(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
            'attachment' => 'required',
            'user_id' => 'required',
            // 'likes_count' => 'required',
            // 'comments_count' => 'required'

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
