@if ($errors->has($name)) <div class="checkbox has-error"> @else <div class="checkbox"> @endif

	<label>
		{{ Form::checkbox($name, $value, $checked, $options) }}
		{{ $label }}
	</label>

	@if ($errors->has($name))
		<p class="help-block">{{ $errors->first($name) }}</p>
	@endif

</div>