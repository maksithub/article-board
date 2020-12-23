@extends('layouts.app')

@section('content')

@php
if(request()->get('cat'))
    $request_val = request()->get('cat');
else{
    $request_val = 'query';
}
@endphp
    <div class="container">

        <h2 class="title">고객문의</h2>
        <div class="blog_categoies">
            <div class="cat_item {@if(request()->get('cat') == 'query' or null == request()->get('cat')) active @endif}">
                <a href="{{url('/queryboard/?cat=query')}}">이용 문의</a>
            </div>
            <div class="cat_item {@if(request()->get('cat') == 'apisample') active @endif}">
                <a href="{{url('/queryboard/?cat=apisample')}}">API 샘플 요청</a>
            </div>
            <div class="cat_item {@if(request()->get('cat') == 'program') active @endif}">
                <a href="{{url('/queryboard/?cat=program')}}">프로그램 제작 요청</a>
            </div>
        </div>
        <!-- Post table -->
        <div class="row">
            <div class="col-md-12">
                <table class="art_table">
                    <thead>
                        <tr>
                            <th scope="col">번호</th>
                            <th scope="col">제목</th>
                            <th scope="col">작성자</th>
                            <th scope="col">작성일</th>
                            <th scope="col">조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $num = $blogs->total() - $blogs->perPage()*($blogs->currentPage()-1); @endphp
                    @forelse ($blogs as $blog)
                    <tr>
                        @if($blog->classification == "notification")
                        <td><b>공지</b></td>
                        @else
                        <td>{{$num}}</td>
                        @endif

                        <td class="left title_col">
                        @if($blog->classification == "notification")
                            <span class="tag">[공지]</span>
                        @endif
                            <a href="{{ url("/user/blogs/{$blog->id}") }}">{{ $blog->title }}</a>
                        </td>
                        <td>{{ $blog->user->name }}</td>
                        <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                        <td>{{views($blog)->unique()->count()}}</td>
                        @php $num = $num-1; @endphp
                    </tr>

                    @forelse ($blog->comments as $comment)
                    <tr>
                        <td></td>
                        <td class="left">
                        <img src="{{asset('img/reply.png')}}" class="replyimg"><a href="{{url("/user/blogs/{$blog->id}/#comments")}}">Re: {{$blog->title}}</a>
                        </td>
                        <td>{{$comment->user->name}}</td>
                        <td>{{$comment->created_at->format('Y-m-d')}}</td>
                        <td>{{views($blog)->unique()->count()}}</td>
                    </tr>
                    @empty

                    @endforelse
                    @empty
                        <tr><td colspan="5">현재 등록된 게시글이 없습니다.</td></tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
        <!-- End posttable -->
        <!-- pagination -->
        <div class="row" style="margin-bottom:25px;">
            <div class="col-md-12">
                <div align="center">
                    @php
                    $paginate_arg = array(
                        'cat' => request()->get('cat')
                    );
                    @endphp
                    {!! $blogs->appends($paginate_arg)->links('layouts._paginate', ['posts' => $blogs]) !!}
                    @if(Auth::user())
                    <div class="create_post pull-right"><a href="{{ url('user/blogs/create').'/?cat='.$request_val }}" class="new_post">글쓰기</a></div>
                    @endif
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <!-- End pagination -->

        @include('frontend._footer')
    </div>
@endsection
