@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h2 style="padding:0 10px;">고객문의</h2>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="header">
                            <h4>
                                @if($blog->classification == 'notification')
                                    [공지]
                                @endif
                                {{ $blog->title }}
                            </h4>
                            @if($blog->attached)
                            <a href="{{asset("storage/uploads/{$blog->attached}")}}" class="pull-right" target="_blank" title="{{$blog->attached}}">
                                <img src="{{asset('img/ic_filedown.gif')}}" alt="">
                            </a>
                            @endif
                        </div>
                        <div class="meta-info row">
                            <div class="col-md-6 d-flex">
                                <div class="text-center meta_label">구분</div>
                                @php
                                    $category = [
                                            'query'=>'이용문의',
                                            'apisample'=>'API 샘플 요청',
                                            'program'=>'프로그램 제작 요청'
                                        ];
                                @endphp
                                <div class="publish_date">{{ $category["{$blog->category}"] }}</div>
                            </div>
                            <div class="col-md-6 d-flex">
                                <div class="text-center meta_label">작성일시</div>
                                <div class="publish_date">{{ $blog->created_at->format('Y년 m월 d일 H시 i분') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if($blog->secretkey)
                        <h5 class="sub_title">비밀글</h5>
                        <p>{{ $blog->secretkey }}</p>
                        <hr>
                        @endif
                        @if($blog->errorlog)
                        <h5 class="sub_title">오류메시지</h5>
                        <p>{{ $blog->errorlog }}</p>
                        <hr>
                        @endif
                        <h5 class="sub_title">내용</h5>
                        <p>{{ $blog->body }}</p>
                    </div>
                </div>

                <div class="footer" style="margin-bottom:20px;">
                    @if($blog->classification=="general")
                    <a href="{{ url('/queryboard').'/?cat='.$blog->category }}" class="btn btn-default">목록</a>
                    @else
                    <a href="{{ url('/queryboard') }}" class="btn btn-default">목록</a>
                    @endif
                    <div class="pull-right">
                    @if(!empty(Auth::user()->id == $blog->user_id))
                        <a href="{{ url("/user/blogs/{$blog->id}/edit") }}" class="btn btn-default">편집</a>
                        <a href="{{ url("/user/blogs/{$blog->id}") }}" data-method="DELETE" data-token="{{ csrf_token() }}" data-confirm="게시글을 삭제하시겠습니까?" class="btn btn-danger">삭제</a>
                    @endif
                    </div>
                </div>
                @if($blog->classification=='general')
                <div class="comments-wrapper" id="comments">
                    <h3>답변글</h3>
                    <div class="panel panel-default panel-comments">
                        @include('blogs._comments')
                        @includeWhen((Auth::user()->is_admin), 'blogs._commentform')
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
@endsection
