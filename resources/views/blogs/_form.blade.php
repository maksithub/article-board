
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

    <!-- 비밀글 -->
    @if(auth()->user()->is_admin == true)
    <tr class="form-group{{ $errors->has('secretkey') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('secretkey', '비밀글', ['class' => 'control-label']) !!}</td>
        <td>{!! Form::text('secretkey', null, ['class' => 'form-control']) !!}

            <span class="help-block">
                <strong>{{ $errors->first('secretkey') }}</strong>
            </span>
        </td>
    </tr>
    @endif

    <!-- 분류 -->
    @if(auth()->user()->is_admin == true)
        <tr class="form-group{{ $errors->has('classification') ? ' has-error' : '' }}">
            <td class="label_cell">{!! Form::label('classification', '분류', ['class' => 'control-label']) !!}</td>
            <td align="left" class="options">
                <div class="group">
                {{Form::radio('classification', 'notification', true, ['id' => 'notification'])}}
                {!! Form::label('notification', '[공지]') !!}
                </div>
                <div class="group">
                {{Form::radio('classification', 'general', false, ['id' => 'general'])}}
                {!! Form::label('general', '[일반]') !!}
                </div>
                <span class="help-block">
                    <strong>{{ $errors->first('classification') }}</strong>
                </span>
            </td>
        </tr>
    @else
        <input type="hidden" name="classification" value="general">
    @endif

    <!-- 구분 -->
    <tr class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('category', '구분', array('class' => 'control-label')) !!}</td>
        <td align="left" class="options">
            @php
                $categories = array(
                    'query' => '이용문의',
                    'apisample' => 'API 샘플 요청',
                    'program' => '프로그램 제작 문의'
                );
            @endphp
            @foreach($categories as $key=>$category)
            <div class="group">
                @if($key == $catval)
                    {!! Form::radio('category', $key, true, array('id' => $key)) !!}
                @else
                    {!! Form::radio('category', $key, false, array('id' => $key)) !!}
                @endif
                {!! Form::label($key, $category) !!}
            </div>
            @endforeach
            <span class="help-block">
                <strong>{{ $errors->first('category') }}</strong>
            </span>
        </td>
    </tr>
    
    <!-- 첨부파일 -->
    <tr class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
    <td class="label_cell">{!! Form::label('file', '첨부파일', ['class' => 'control-label']) !!}</td>
        <td>
            <!-- Disable if query catval-->
            @if($catval =='query' or !$catval)
                {!! Form::file('file') !!}
            @else
                {!! Form::file('file', ["disabled"]) !!}
            @endif
            @if(!empty($blog) && $blog->attached)
            <a href="{{ asset("storage/uploads/{$blog->attached}") }}" class="pull-right" target="_blank" style="margin-top:3px;">
                <span style="margin-right:3px;">{{$blog->attached}}</span><img src="{{asset('img/ic_filedown.gif')}}" alt="">
            </a>
            @endif
            <li align="left" style="margin-top:3px;" class="{{ $errors->has('file') ? 'has-error' : '' }}"> 올릴 수 있는 파일의 크기는 <span style="color:red;">2MB</span> 입니다.</li>
            <!-- <span class="help-block">
                <strong>{{ $errors->first('file') }}</strong>
            </span> -->
        </td>
    </tr>

    <!-- 오류메세지 -->
    <tr class="form-group{{ $errors->has('errorlog') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('errorlog', '오류메시지', ['class' => 'control-label']) !!}</td>
        <td>
            <!-- Disable if query catval-->
            @if($catval =='query' or !$catval)
                {!! Form::textarea('errorlog', null, ['class' => 'form-control', 'rows' => '5']) !!}
            @else
                {!! Form::textarea('errorlog', null, ['class' => 'form-control', 'rows' => '5', 'disabled']) !!}
            @endif
            <li align="left" style="margin-top:3px;"> 오류메시지와 내용을 상세히 작성해주시면 보다 신속한 답변이 가능합니다.</li>
            <span class="help-block">
                <strong>{{ $errors->first('errorlog') }}</strong>
            </span>
        </td>
    </tr>

    <!-- 내용 -->
    <tr class="form-group file_wrapper{{ $errors->has('body') ? ' has-error' : '' }}">
        <td class="label_cell">{!! Form::label('body', '내용', ['class' => 'control-label']) !!}</td>
        <td>{!! Form::textarea('body', null, ['class' => 'form-control']) !!}
            <span class="pull-right" style="margin-top:3px;"><span class="counter"></span> / 2000</span>
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        </td>
    </tr>

</table>

<script>
    // Disable Errorlog area if not query
    jQuery("input[name='category']").click(function(){
        if(jQuery(this).attr("id") != 'query'){
            jQuery("textarea[name='errorlog']").prop( "disabled", true );
            jQuery("input[name='file']").prop( "disabled", true );
        }else{
            jQuery("textarea[name='errorlog']").prop( "disabled", false );
            jQuery("input[name='file']").prop( "disabled", false );
        }
    });

    // Count letters of body textarea
    jQuery(document).ready(function(){
        var bodyContentLength = 0;
        bodyContentLength = jQuery("textarea[name='body']").text().length;
        jQuery(".counter").text(bodyContentLength);
    });
    jQuery("textarea[name='body']").keyup(function(){
        var bodyContentLength = jQuery(this).val().length;
        jQuery(".counter").text(bodyContentLength);
    });

    // File size Validation
    jQuery('#file').bind('change', function() {
        let filesize = this.files[0].size // On older browsers this can return NULL.
        let filesizeMB = (filesize / (1024*1024)).toFixed(2);
        if(filesizeMB <= 2) {
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
        var errorLen = jQuery('textarea[name="errorlog"]').val();
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
        if(errorLen.length >=2000){
            jQuery('textarea[name="errorlog"]').closest(".form-group").addClass("has-error");
            jQuery('textarea[name="errorlog"]').nextAll().eq(1).find("strong").text("오류메시지는 2000자를 초과할수 없습니다.");
            return false;
        }    
        if(!bodyLen){
            jQuery('textarea[name="body"]').closest(".form-group").addClass("has-error");
            jQuery('textarea[name="body"]').nextAll().eq(1).find("strong").text("내용을 입력하세요.");
            return false;
        }
        if(bodyLen.length >=2000){
            jQuery('textarea[name="body"]').closest(".form-group").addClass("has-error");
            jQuery('textarea[name="body"]').nextAll().eq(1).find("strong").text("내용은 2000자를 초과할수 없습니다.");
            return false;
        }
    });
</script>