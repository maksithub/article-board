<table class="full-width form-table">
    <!-- 제목 -->
    <tr class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('title', '제목', ['class' => 'control-label']) !!}</td>
        <td>{!! Form::text('title', null, ['class' => 'form-control', 'autofocus']) !!}

            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        </td>
    </tr>
    <!-- 분류 -->
    <tr class="form-group{{ $errors->has('classification') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('classification', '분류', ['class' => 'control-label']) !!}</td>
        <td align="left" class="options">
            <div class="group">
            {{Form::radio('classification', 'notification', true, ['id'=>'notification'])}}
            {!! Form::label('notification', '[공지]') !!}
            </div>
            <div class="group">
            {{Form::radio('classification', 'general', false, ['id'=>'general'])}}
            {!! Form::label('general', '[일반]') !!}
            </div>
            <span class="help-block">
                <strong>{{ $errors->first('classification') }}</strong>
            </span>
        </td>
    </tr>
    <!-- 테마 -->
    <tr class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('', '테마', array('class' => 'control-label')) !!}</td>
        <td align="left" class="options">
            @foreach($categories as $key=>$category)
            <div class="group">
                @if($loop->first )
                    {!! Form::radio('category_id', $category->id, true, array('id' => 'cat_'.$category->id)) !!}
                @else
                    {!! Form::radio('category_id', $category->id, false, array('id' => 'cat_'.$category->id)) !!}
                @endif
                {!! Form::label('cat_'.$category->id, $category->name) !!}
            </div>
            @endforeach
            <span class="help-block">
                <strong>{{ $errors->first('category_id') }}</strong>
            </span>
        </td>
    </tr>
    <!-- 언어 -->
    <tr class="form-group{{ $errors->has('lang_id') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('langs', '언어', ['class' => 'control-label']) !!}</td>
        <td align="left" class="options">
            @foreach($langs as $lang)
                <div class="group">
                    @if($loop->first )
                        {{Form::radio('lang_id', $lang->id, true, array('id'=> 'lang_'.$lang->id))}}
                    @else
                        {{Form::radio('lang_id', $lang->id, false, array('id'=> 'lang_'.$lang->id))}}
                    @endif
                    {!! Form::label('lang_'.$lang->id, $lang->name) !!}
                </div>
            @endforeach
            <span class="help-block">
                <strong>{{ $errors->first('lang_id') }}</strong>
            </span>
        </td>
    </tr>
    
    <!-- 첨부화일 -->
    <tr class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
    <td class="label_cell">{!! Form::label('file', '첨부파일', ['class' => 'control-label']) !!}</td>
        <td>{!! Form::file('file', null, ['class' => 'form-control']) !!}
        <li align="left" style="margin-top:3px;" class=""> 올릴 수 있는 파일의 크기는 <span style="color:red;">10MB</span> 입니다.</li>
            <span class="help-block">
                <strong>{{ $errors->first('file') }}</strong>
            </span>
        </td>
    </tr>
    <!-- 내용 -->
    <tr class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('body', '내용', ['class' => 'control-label']) !!}</td>
        <td>{!! Form::textarea('body', null, ['class' => 'form-control']) !!}

            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        </td>
    </tr>

</table>

<script>
    // File size Validation
    jQuery('#file').bind('change', function() {
        let filesize = this.files[0].size // On older browsers this can return NULL.
        let filesizeMB = (filesize / (1024*1024)).toFixed(2);
        if(filesizeMB <= 10) {
            jQuery(this).closest(".form-group").removeClass("has-error");
            jQuery("button[type='submit']").prop("disabled", false);
        } else {
            jQuery(this).closest(".form-group").addClass("has-error");
            jQuery("button[type='submit']").prop("disabled", true);
        }
    });

    // Javascript Validation
    jQuery("form").submit(function(event){
        // event.preventDefault();
        jQuery(".form-group").removeClass("has-class");
        var titleLen = jQuery('input[name="title"]').val();
        var bodyLen = jQuery('textarea[name="body"]').val();
        if(!titleLen){
            jQuery('input[name="title"]').closest(".form-group").addClass("has-error");
            jQuery('input[name="title"]').next(".help-block").find("strong").text("제목을 입력하세요.");
            return false;
        }
        if(titleLen.length >=30 ){
            jQuery('input[name="title"]').closest(".form-group").addClass("has-error");
            jQuery('input[name="title"]').next(".help-block").find("strong").text("제목은 30자를 초과할수 없습니다.");
            return false;
        }
        if(!bodyLen){
            jQuery('textarea[name="body"]').closest(".form-group").addClass("has-error");
            jQuery('textarea[name="body"]').nextAll().eq(0).find("strong").text("내용을 입력하세요.");
            return false;
        }
        if(bodyLen.length >=2000){
            jQuery('textarea[name="body"]').closest(".form-group").addClass("has-error");
            jQuery('textarea[name="body"]').nextAll().eq(0).find("strong").text("내용은 2000자를 초과할수 없습니다.");
            return false;
        }
    });
</script>