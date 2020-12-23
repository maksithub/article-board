<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class QueryboardController extends Controller
{
    public function index(Request $request){
        
        $user_id = auth()->user()->id;

        // Get blogs by tabs
        $blogs = Blog::when($request->cat, function($query) use($request) {
            $cat = $request->cat;
            return $query->where('category', '=', "$cat");
        }, function ($query) {
            return $query->where('category', '=', "query");
        });

        // Show 'notifications' on tabs
        if(auth()->user()->is_admin == false){
            $blogs = $blogs->where('user_id', '=', "$user_id")->orwhere('user_id', '=', '1')->where('classification','=','notification');
        }else{
            $blogs = $blogs->orwhere('user_id', '=', '1');
        }

        $blogs = $blogs->with('user')
        ->withCount('comments')
        ->published()
        ->orderBy('classification', 'desc')
        ->latest()
        ->paginate(10);

        return view('blogs.index', compact('blogs'));
    }

}
