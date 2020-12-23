<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $catval = request()->get('cat');
        return view('blogs.create', compact('catval'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request, Blog $blog)
    {
        $blog = new Blog;
        $args = [
            'title'       => $request->title,
            'body'        => $request->body,
            'secretkey'        => $request->secretkey,
            'errorlog'        => $request->errorlog,
            'category' => $request->category,
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
        
        $blog->create($args);

        // flash()->overlay('Post created successfully.');

        return redirect('/queryboard/?cat='.$request->category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $blog = $blog->load(['user']);
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $catval = $blog->category;
        views($blog)->record();
        return view('blogs.edit', compact('blog', 'catval'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $args = [
            'title'       => $request->title,
            'body'        => $request->body,
            'secretkey'   => $request->secretkey,
            'errorlog'    => $request->errorlog,
            'category' => $request->category,
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
        
        $blog->update($args);

        // flash()->overlay('Post created successfully.');
       
        return redirect('/user/blogs/'.$blog->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect('/queryboard');
    }
}
