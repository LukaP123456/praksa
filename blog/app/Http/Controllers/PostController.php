<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        try {
            $post = Post::create([
                'title' => $request['post_title'],
                'body' => $request['post_body'],
            ]);

            if (!empty($post)) {
                return response()->json(['status' => 200, 'message' => 'New post created']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, int $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->title = $request->post_title;
            $post->body = $request->post_body;

            if ($post->save()) {
                return response()->json(['status' => 200, 'message' => 'Post updated successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $post = Post::findOrFail($id);
            if ($post->delete()) {
                return response()->json(['status' => 200, 'message' => 'Post deleted successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

}
