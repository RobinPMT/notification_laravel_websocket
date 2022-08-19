<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\PostLikeNotification;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::where('user_id', '!=', auth()->user()->id)->with('user')->get();
        $viewData = [
          'posts' => $posts
        ];
        return view('home', $viewData);
    }

    public function postLike(Request $request)
    {
        $user = auth()->user();
        $post = Post::with('user')->find($request->post_id);

        $author = $post->user;

        $author->notify(new PostLikeNotification($user, $post));

        $data = [
              'status' => true,
              'data' =>  [
                  'user' => $user,
                  'post' => $post
              ]
        ];
        return response()->json($data);
    }
}
