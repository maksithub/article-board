@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <h2>자료실</h2>
                    <div class="panel-body" style="padding:0;">
                        {!! Form::open(['url' => '/admin/posts/', 'class' => 'form-horizontal', 'role' => 'form','files'=> true]) !!}

                            @include('admin.posts._form')

                            <div class="form-group">
                                <div class="process text-center">
                                    <button type="submit" class="btn btn-primary">
                                        등록
                                    </button>
                                    <a href="{{ url('/') }}" class="btn btn-default">취소</a>
                                </div>
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
