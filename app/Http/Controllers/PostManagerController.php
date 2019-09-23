<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PostManagerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $posts = Post::with('author')->orderBy('updated_at', 'DESC')->get();
        return view('admin.post.list', ['posts' => $posts]);
    }

    /**
     * @param Request $request
     * @param $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setSchedulePost(Request $request, $postId)
    {
        $publisedAt = ($request->published_at != null) ? Carbon::parse($request->published_at) : Carbon::now();
        $post = Post::find($postId);
        if ($publisedAt->greaterThanOrEqualTo(Carbon::now())) {
            $post->status = Config::get('constants.POST_STATUS.SCHEDULING');
        } else {
            $post->status = Config::get('constants.POST_STATUS.PUBLISHED');
        }
        $post->published_at = $publisedAt->format('Y-m-d h:i:s');
        $post->save();
        return redirect()->back()->with('success', 'Set schedule successfull !');
    }

    /**
     * @param $postId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unpublishPost($postId)
    {
        $post = Post::find($postId);
        $post->status = Config::get('constants.POST_STATUS.DRAFT');
        $post->published_at = null;
        $post->save();
        return redirect()->back()->with('success', 'Post Unpublished successfull');
    }
}
