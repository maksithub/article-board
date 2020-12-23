<div class="form-search">
{!! Form::open(['method' => 'GET', 'role' => 'form']) !!}
        <div class="classified">
            {!! Form::select('classification', array('title' => '제목', 'body' => '내용', 'all' => '제목+내용'), request()->get('classification')) !!}
        </div>
        <div class="search">
            {!! Form::text('search', request()->get('search'), ['class' => 'form-control']) !!}
        </div>
        <div class="submit">
            {!! Form::submit('검색', ['class' => 'btn btn-block btn-default form-control']) !!}
        </div>
{!! Form::close() !!}
</div>