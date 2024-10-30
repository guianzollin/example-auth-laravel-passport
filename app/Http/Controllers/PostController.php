<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
 
class PostController extends Controller
{
    /**
     * Store.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $user = Auth::user();
 
        $post = $user->posts()->create([
            'title' => $request->title,
        ]);

        return response(['post' => $post]);
    }

    /**
     * Update the given post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (! Gate::allows('update-post', $post)) {
            abort(403, 'Forbidden');
        }

        $post->title = $request->title;
        $post->save();
 
        return response(['message' => 'Post updated!']);
    }
}
