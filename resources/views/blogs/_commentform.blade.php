
    <div class="panel-body">
        {!! Form::open(['url' => "user/blogs/{$blog->id}/comments", 'class' => 'comment_form']) !!}
            <div class="form-group{{ $errors->has('comment_body') ? ' has-error' : '' }}">
                {!! Form::textarea('comment_body', null, ['class' => 'form-control', 'rows' => 3]) !!}
                <span class="pull-right" style="margin-top:3px;"><span class="comment_counter">0</span> / 2000</span>
            <span class="help-block">
                <strong>{{ $errors->first('comment_body') }}</strong>
            </span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    등록
                </button>
            </div>
        {!! Form::close() !!}
        
        <a href="#" class="btn btn-default pull-right comment_show">답글쓰기</a>
    </div>


<script>
    jQuery("textarea[name='comment_body']").keyup(function(){
        var commentContentLength = jQuery(this).val().length;
        jQuery(".comment_counter").text(commentContentLength);
    });

    jQuery(".comment_show").click(function(e){
        jQuery(".comment_form").toggle();
        return false;
    });
</script>