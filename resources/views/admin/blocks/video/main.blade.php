<?php
$input_id = str_replace(['[', ']'], ['_', ''], $name);
$placeHolderData = [];
$content = $submitted_data?:$content;
if ($content) {
    $videoData = \CoasterCms\Libraries\Blocks\Video::dl('videos', ['id' => $content, 'part' => 'id,snippet']);
    $placeHolderData = (!empty($videoData))?[$content => $videoData->snippet->title]:[];
}
?>

<div class="form-group {{ $field_class }}">
    {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
    <div class="col-sm-10">
        {!! Form::hidden($name . '[exists]', 1) !!}
        {!! Form::select($name . '[select]', $placeHolderData, $content, ['class' => 'form-control video-search', 'id' => $input_id, 'style' => 'width:100%;']) !!}
        <a href="javascript:$('#{!! $input_id !!}').select2('val', ''); $('#{!! $input_id !!}_preview').css('display', 'none');">
            Clear selection</a>
        <div style="padding-top: 10px;">
            <iframe id="{!! $input_id !!}_preview" class="pull-left yt-video"
                    src="{!! $placeHolderData?'http://www.youtube.com/embed/'.$content:'' !!}" width="300" height="200"
                    style="padding-right:15px;border:0;{!! empty($placeHolderData)?'display:none':'' !!}"></iframe>
            <p class="pull-left">Results are generated by YouTube's search system.</p>
        </div>
        <span class="help-block">{{ $field_message }}</span>
    </div>
</div>