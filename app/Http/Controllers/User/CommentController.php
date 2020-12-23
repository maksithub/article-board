<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;
use App\Models\Comment;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function show(Request $request, Blog $blog,Comment $comment){

        views($blog)->record();
        return view('blogs.show', compact('blog', 'comment'));
    }

    public function store(Request $request, Blog $blog)
    {   
        $rule = [
            'comment_body' => 'required|max:2000',
        ];
        $customMessages = [
            'required' => '답변글을 입력하세요.',
            'max' => '2000자를 초과할 수 없습니다.',
        ];
        $this->validate($request, $rule, $customMessages);
        $blog->comments()->create([
            'body' => $request->comment_body
        ]);
        // flash()->overlay('Comment successfully created');

        return redirect("/user/blogs/".$blog->id);
    }

    function update(Request $request, Blog $blog, Comment $comment)
    {           
        $comment->update([
            'body' => $request->comment_edit
        ]);
        // flash()->overlay('Comment successfully created');

        return redirect("/user/blogs/".$blog->id);
    }

    public function destroy(Blog $blog, Comment $comment)
    {
        $comment->delete();
        $cat = $blog->category;
        return redirect("/user/blogs/".$blog->id);
    }

}
