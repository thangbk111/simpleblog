<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMyPost()
    {
        $posts = Post::with('author')->where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->get();
        return view('post.my_post', [ 'posts' => $posts ]);
    }

    public function showPostDetail($slug)
    {
        $this->authorize('view-post');
        $post = Post::where('slug', $slug)->first();
        return view('post.show', ['post' => $post]);
    }

    public function edit($slug)
    {
        $this->authorize('update-post');
        $post = Post::where('slug', $slug)->first();
        return view('post.edit', ['post' => $post]);
    }

    public function update(Request $request, $slug)
    {
        $this->authorize('update-post');
        $validator = $this->validatePostData($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $post = Post::where('slug', $slug)->first();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->body = $request->body;
        $post->save();
        return redirect()->back()->with('success', 'Update Post:' . $post->title . ' successful !');
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validatePostData($request->all());
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->body = $request->body;
        $post->status = Config::get('constants.POST_STATUS.DRAFT');
        $post->user_id = Auth::id();
        $post->save();
        return redirect()->back()->with('success', 'Create Post:' . $post->title . ' successful !');
    }

    public function delete($id)
    {
        $this->authorize('delete-post');
        Post::destroy($id);
        return redirect()->back()->with('success', 'Delete post successful !');
    }
    /**
     * @param $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    function validatePostData($data)
    {
        return Validator::make($data, [
            'title' => 'required',
            'body' => 'required'
        ]);
    }
}
