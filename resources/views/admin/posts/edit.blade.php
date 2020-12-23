@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            
            <div class="col-md-12">
                <div class="panel">
                    <h2 style="padding:0 20px;margin-bottom:0;">자료실</h2>
                    <div class="panel-body">
                        {!! Form::model($post, ['method' => 'PUT', 'url' => "/admin/posts/{$post->id}", 'class' => 'form-horizontal', 'role' => 'form','files'=> true]) !!}

                            @include('admin.posts._form')
                            <div class="form-group process">
                            <div class="col-md-3" align="left">
                                <a href="{{ url('/') }}" class="btn btn-default">목록</a>
                            </div>
                            <div class="col-md-9" align="right">
                                <button type="submit" class="btn btn-primary">수정</button>
                                <a href="{{ url("/admin/posts/{$post->id}") }}" data-method="DELETE" data-token="{{ csrf_token() }}" data-confirm="게시글을 삭제하시겠습니까?" class="btn btn-danger">삭제</a>
                            </div>
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
