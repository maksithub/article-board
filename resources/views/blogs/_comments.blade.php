@forelse ($blog->comments as $comment)
    <div class="panel-body">
        <p class="comment @if(!empty(Auth::user()->is_admin))short @endif">{{ $comment->body }}</p>
        @if(!empty(Auth::user()->is_admin))
        <a href="{{ url("/user/blogs/{$blog->id}/comments/{$comment->id}") }}" data-method="DELETE" data-token="{{ csrf_token() }}" data-confirm="답변글을 삭제하시겠습니까?" class="btn btn-danger pull-right">삭제</a>
        <a href="{{ url("/user/blogs/{$blog->id}/comments/{$comment->id}/edit") }}" class="btn btn-default pull-right comEditBut" style="margin-right:5px;">편집</a>
        <a href="#" class="btn btn-default pull-right comUpdate" style="margin-right:5px;">수정</a>
        @endif
        {!! Form::open(['url' => "user/blogs/{$blog->id}/comments/{$comment->id}", 'class' => 'comment_edit_form short']) !!}
            {{ method_field('PATCH') }}
            <div class="form-group{{ $errors->has('comment_body') ? ' has-error' : '' }}">
                {!! Form::textarea('comment_edit', null, ['class' => 'form-control comment_edit_area', 'rows' => 3]) !!}
                <span class="pull-right" style="margin-top:3px;"><span class="comment_counter">0</span> / 2000</span>
            <span class="help-block">
                <strong>{{ $errors->first('comment_body') }}</strong>
            </span>
            </div>
        {!! Form::close() !!}
        <div style="clear:both;"></div>
        <hr>
    </div>
@empty
    <div class="panel-body">
        <p>답변글이 없습니다.</p>
    </div>

@endforelse

<script>
    jQuery(".comEditBut").click(function(e){
        jQuery(this).hide();
        var comment = jQuery(this).closest(".panel-body").find(".comment");
        comment.hide();
        jQuery(this).closest(".panel-body").find(".comment_edit_form").show().find(".comment_edit_area").val(comment.text());
        jQuery(this).next(".comUpdate").show();
        return false;
    });
    jQuery(".comUpdate").click(function(e){
        e.preventDefault();
        var bodyLen = jQuery(this).next('.comment_edit_form').find(".comment_edit_area").val();
        if(!bodyLen){
            jQuery(this).next('.comment_edit_form').find(".comment_edit_area").closest(".form-group").addClass("has-error");
            jQuery(this).next('.comment_edit_form').find(".comment_edit_area").nextAll().eq(1).find("strong").text("내용을 입력하세요.");
            return false;
        }
        if(bodyLen.length >=2000){
            jQuery(this).next('.comment_edit_form').find(".comment_edit_area").closest(".form-group").addClass("has-error");
            jQuery(this).next('.comment_edit_form').find(".comment_edit_area").nextAll().eq(1).find("strong").text("내용은 2000자를 초과할수 없습니다.");
            return false;
        }
        jQuery(this).next("form").submit();

    });

</script>
