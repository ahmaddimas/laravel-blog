<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function dashboard()
    {
        $posts      = Auth::user()->posts->count();
        $comments   = Auth::user()->comments->count();
        $categories = Category::count();

        return view('user.dashboard', get_defined_vars());
    }

    public function posts()
    {
        $posts = Auth::user()->posts()->paginate(10);
        return view('user.posts', compact('posts'));
    }

    public function categories()
    {
        if (Auth::user()->isNotAdmin()) {
            abort(404);
        }
        return view('user.categories');
    }

    public function comments()
    {
        $comments = Auth::user()->comments()->paginate(10);
        return view('user.comments', compact('comments'));
    }
}
