<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\Lang;
use Illuminate\Http\Request;

class DataboardController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::when($request->search, function($query) use($request) {
                        $search = $request->search;
                        $classification = $request->classification;
                        if($classification == 'all'){
                            $result = $query->where('title', 'like', "%$search%")
                            ->orWhere('body', 'like', "%$search%");
                        }else{
                            $result = $query->where($classification, 'like', "%$search%");
                        }
                        return $result;
                    })->when($request->cat, function($query) use($request) {
                        $cat = $request->cat;
                        return $query->where('category_id', '=', "$cat");
                    })->when($request->lang, function($query) use($request) {
                        $lang = $request->lang;
                        return $query->where('lang_id', '=', "$lang");
                    })->with('lang', 'category', 'user')
                    ->published()
                    ->orderBy('classification', 'desc')
                    ->latest()
                    ->paginate(10);
        $posts_count_all = Post::count();
        $general_posts_count = Post::where('classification', '=', 'general')->count();
        $categories = Category::withCount('posts')->get();
        $langs = Lang::withCount('posts')->get();
        return view('frontend.index', compact('posts', 'categories','langs','posts_count_all', 'general_posts_count'));
    }

    public function post(Post $post)
    {
        $result = $post->load(['user', 'category']);
        views($post)->record();
        return view('frontend.post')->with('post', $result);
    }

    public function comment(Request $request, Post $post)
    {
        $this->validate($request, ['body' => 'required']);

        $post->comments()->create([
            'body' => $request->body
        ]);
        flash()->overlay('Comment successfully created');

        return redirect("/posts/{$post->id}");
    }
}
