@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="title">자료실</h2>

        @include('frontend._search')
        @include('frontend._filter')

        <!-- Post table -->
        <div class="row">
            <div class="col-md-12">
                <table class="art_table">
                    <thead>
                        <tr>
                            <th scope="col">번호</th>
                            <th scope="col">제목</th>
                            <th scope="col">테마</th>
                            <th scope="col">작성일</th>
                            <th scope="col">조회수</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $num = $posts->total()-$posts->perPage()*($posts->currentPage()-1); @endphp
                    @forelse ($posts as $post)
                    <tr>
                        @if($post->classification == "notification")
                        <td><b>공지</b></td>
                        @else
                        <td>{{$num}}</td>
                        @endif
                        <td class="left title_col">
                        @if($post->classification == "notification")
                            <span class="tag">[공지]</span>
                        @else
                            <span class="lang">[{{$post->lang->name}}]</span>
                        @endif
                            <a href="{{ url("/posts/{$post->id}") }}">{{ $post->title }}</a>
                        </td>
                        <td>{{ $post->category->name }}</td>
                        <td>{{ $post->created_at->format('Y-m-d') }}</td>
                        <td>{{views($post)->unique()->count()}}</td>
                        @php $num = $num-1; @endphp
                    </tr>
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
                        'search' => request()->get('search'),
                        'cat' => request()->get('cat'),
                        'lang' => request()->get('lang')
                    );
                    @endphp
                    {!! $posts->appends($paginate_arg)->links('layouts._paginate', ['posts' => $posts]) !!}
                    
                    @if(!empty(Auth::user()->is_admin))
                    <div class="create_post pull-right"><a href="{{ url('admin/posts/create') }}" class="new_post">글쓰기</a></div>
                    @endif
                </div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <!-- End pagination -->

        @include('frontend._footer')
    </div>
@endsection
