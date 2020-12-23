@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2 style="padding:0 10px;">자료실</h2>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="header">
                            <h4>
                                @unless($post->classification == 'notification')
                                    [{{$post->lang->name}}]
                                @else
                                    [공지]
                                @endunless
                                {{ $post->title }}
                            </h4>
                            @if($post->attached)
                            <a href="{{ asset("storage/uploads/{$post->attached}") }}" class="pull-right" target="_blank" title="{{$post->attached}}">
                                <img src="{{asset('img/ic_filedown.gif')}}" alt="">
                            </a>
                            @endif
                        </div>
                        <div class="meta-info row">
                            <div class="col-md-6 d-flex">
                                <div class="text-center meta_label">테마</div>
                                <div class="publish_date">{{ $post->category->name }}</div>
                            </div>
                            <div class="col-md-6 d-flex">
                                <div class="text-center meta_label">작성일</div>
                                <div class="publish_date">{{ $post->updated_at->format('Y-m-d') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <p>{{ $post->body }}</p>
                    </div>

                    </div>
                </div>

                <div class="form-group process">
                <div class="col-md-3" align="left">
                    <a href="{{ url('/') }}" class="btn btn-default">목록</a>
                </div>
                <div class="col-md-9" align="right">
                @if(!empty(Auth::user()->is_admin))
                    <a href="{{ url("/admin/posts/{$post->id}/edit") }}" class="btn btn-default">편집</a>
                    <a href="{{ url("/admin/posts/{$post->id}") }}" data-method="DELETE" data-token="{{ csrf_token() }}" data-confirm="게시글을 삭제하시겠습니까?" class="btn btn-danger">삭제</a>
                @endif
                </div>
                <div style="clear:both;"></div>

            </div>

        </div>
    </div>
@endsection
