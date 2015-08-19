@if ($errors->has($name)) <div class="form-group has-error"> @else <div class="form-group"> @endif

	@if (!is_null($label))
		{{ Form::label($name, $label, ['class' => 'control-label']) }}
	@endif

	{{ Form::textarea($name, $value, $options + ['class' => 'form-control', 'placeholder' => $label]) }}

	@if ($errors->has($name))
		<p class="help-block">{{ $errors->first($name) }}</p>
	@endif

</div>