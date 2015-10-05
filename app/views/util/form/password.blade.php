@if ($errors->has($name)) <div class="form-group has-error"> @else <div class="form-group"> @endif

	@if (!is_null($label))
		{{ Form::label($name, $label, ['class' => 'control-label']) }}
	@endif	

	{{ Form::password($name, $options + ['class' => 'form-control']) }}

	@if ($errors->has($name))
		<p class="help-block">{{ $errors->first($name) }}</p>
	@endif

</div>