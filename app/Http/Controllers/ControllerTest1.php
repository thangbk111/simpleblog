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
    public function index(Request $request)
    {
        //git test

        //Add something new here

        // nearly fishnish my code

        //add new


        //add new 002


        $post = Post::find($request->all());
        return view('home.home', ['posts' => $posts]);
    }
}
