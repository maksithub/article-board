<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use App\Models\Lang;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->is_admin == false){
            flash()->overlay("관리자권한이 필요합니다.");
            return redirect('/');
        }
        $posts = Post::with(['user', 'category'])->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select('name','id')->get();
        $langs = Lang::select('name', 'id')->get();
        return view('admin.posts.create', compact('categories', 'langs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
        $args = [
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $request->category_id,
            'lang_id'     => $request->lang_id,
            'classification'=>$request->classification,
            'is_published' => 1
        ];
        if($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            // Get filename with extension           
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            // Get just ext
            $extension = $request->file('file')->getClientOriginalExtension(); 
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension; 
            // Upload Image
            $path = $request->file('file')->storeAs('public/uploads', $fileNameToStore);
            $args['attached'] = $fileNameToStore;
        }
        
        $post->create($args);

        flash()->overlay('Post created successfully.');

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = $post->load(['user', 'category', 'tags']);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // if($post->user_id != auth()->user()->id && auth()->user()->is_admin == false) {
        //     flash()->overlay("You can't edit other peoples post.");
        //     return redirect('/admin/posts');
        // }

        $categories = Category::select('name','id')->get();
        $langs = Lang::select('name', 'id')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'langs'));
        // return view('admin.posts.edit', compact('categories', 'langs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $args = array(
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $request->category_id,
            'lang_id'     => $request->lang_id,
            'classification'=>$request->classification,
        );

        if($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            // Get filename with extension           
            $filenameWithExt = $request->file('file')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); 
            // Get just ext
            $extension = $request->file('file')->getClientOriginalExtension(); 
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension; 
            // Upload Image
            $path = $request->file('file')->storeAs('public/uploads', $fileNameToStore);
            $args['attached'] = $fileNameToStore;
        }
        $post->update($args);

        // flash()->overlay('Post updated successfully.');

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // if($post->user_id != auth()->user()->id && auth()->user()->is_admin == false) {
        //     flash()->overlay("You can't delete other peoples post.");
        //     return redirect('/admin/posts');
        // }

        $post->delete();

        return redirect('/');
    }

    public function publish(Post $post)
    {
        $post->is_published = !$post->is_published;
        $post->save();
        flash()->overlay('Post changed successfully.');

        return redirect('/admin/posts');
    }
}
