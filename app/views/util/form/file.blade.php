@if ($errors->has($name)) <div class="form-group has-error"> @else <div class="form-group"> @endif

	{{ Form::file($name, $options + ['class' => 'form-control']) }}

	@if ($errors->has($name))
		<p class="help-block">{{ $errors->first($name) }}</p>
	@endif

</div>