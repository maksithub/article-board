@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                <h2 class="title" style="padding: 0 20px;margin-bottom:0;">고객문의 작성하기</h2>
                    
                    <div class="panel-body">
                        {!! Form::model($blog, ['method' => 'PUT', 'url' => "user/blogs/{$blog->id}", 'class' => 'form-horizontal', 'role' => 'form','files'=> true]) !!}

                            @include('blogs._form')

                            <div class="form-group process">
                            <div class="col-md-3" align="left">
                                <a href="{{ url("/user/blogs/{$blog->id}") }}" class="btn btn-default">돌아가기</a>
                            </div>
                            <div class="col-md-9" align="right">
                            @if($blog->classification == 'general')
                                @if(auth()->user()->is_admin == false)
                                <button type="submit" class="btn btn-primary">수정</button>
                                <a href="{{ url("/user/blogs/{$blog->id}") }}" data-method="DELETE" data-token="{{ csrf_token() }}" data-confirm="게시글을 삭제하시겠습니까?" class="btn btn-danger">삭제</a>
                                @endif
                            @else
                                @if(!empty(Auth::user()->is_admin))
                                <button type="submit" class="btn btn-primary">수정</button>
                                <a href="{{ url("/user/blogs/{$blog->id}") }}" data-method="DELETE" data-token="{{ csrf_token() }}" data-confirm="게시글을 삭제하시겠습니까?" class="btn btn-danger">삭제</a>
                                @endif
                            @endif
                            </div>
                            </div>
                            

                        {!! Form::close() !!}

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


