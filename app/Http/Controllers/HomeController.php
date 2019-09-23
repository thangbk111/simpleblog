<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::with('author')->where('status', Config::get('constants.POST_STATUS.PUBLISHED'))->orderBy('updated_at', 'DESC')->get();
        return view('home.home', ['posts' => $posts]);
    }
}
