<div class="form-group">
    @if(@caption)
    <label for="{{$name}}">{{$caption}}</label>
@endif
	<div class="input-group{{$feedback ? ' has-' . $feedback : ''}}">
    @if( $addon['before'])
    	<span class="input-group-addon">{{$addon['before']}}</span>
    @endif
    {{ Form::text($name, $value, $attributes) }}
    @if( $addon['after'])
    	<span class="input-group-addon">{{$addon['after']}}</span>
    @endif
	</div>
</div>
@if($help)
    <p class="help-block">{{$help}}</p>
@endif