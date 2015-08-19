@if ($errors->has($name)) <div class="form-group has-error"> @else <div class="form-group"> @endif

	@if (!is_null($label))
		{{ Form::label($name, $label, ['class' => 'control-label']) }}
	@endif
	@if(!is_null($group))
		<div class="input-group">
		{{ Form::text($name, $value, 
			$options + 
			['class' => 'form-control auto text-right', 
			'type' => 'text', 
			'data-a-dec' => ',', 
			'data-a-sep' => '.']) }}			
		<span class="input-group-addon">{{ $group }}</span>
		</div>
		
	@else
		{{ Form::text($name, $value, $options + ['class' => 'form-control auto text-right', 'type' => 'text', 'data-a-dec' => ',', 'data-a-sep' => '.']) }}
	@endif

	@if ($errors->has($name))
		<p class="help-block">{{ $errors->first($name) }}</p>
	@endif

</div>