@if ($errors->has($name)) <div class="form-group has-error"> @else <div class="form-group"> @endif

	@if (!is_null($label))
		{{ Form::label($name,  $label, ['class' => 'control-label']) }} 
		@if (!is_null($icon) && (!is_null($ruta)))
			<a href="{{ $ruta }}"><i class="{{ $icon }}"></i></a>                                           
		@endif
	@endif	

	{{ Form::select($name, $list, $selected, $options + ['class' => 'form-control', 'placeholder' => $label]) }}

	@if ($errors->has($name))
		<p class="help-block">{{ $errors->first($name) }}</p>
	@endif

</div>