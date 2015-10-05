<?php


Form::macro('textField', function($label, $name, $value = null, $options = array(), $group = null)
{
	$data = compact('label', 'name', 'value', 'options','group');

	return View::make('util.form.text', $data)->render();
});

Form::macro('textNumericField', function($label, $name, $value = null, $options = array(), $group = null)
{
	$data = compact('label', 'name', 'value', 'options','group');

	return View::make('util.form.text_numeric', $data)->render();
});

Form::macro('date', function($label, $name, $value = null, $options = array())
{
	$data = compact('label', 'name', 'value', 'options');

	return View::make('util.form.date', $data)->render();
});

Form::macro('textareaField', function($label, $name, $value = null, $options = array())
{
	$data = compact('label', 'name', 'value', 'options');

	return View::make('util.form.textarea', $data)->render();
});

Form::macro('passwordField', function($label, $name, $options = array())
{
	$data = compact('label', 'name', 'options');

	return View::make('util.form.password', $data)->render();
});

Form::macro('checkboxField', function($label, $name, $value = 1, $checked = null, $options = array())
{
	$data = compact('label', 'name', 'value', 'checked', 'options');

	return View::make('util.form.checkbox', $data)->render();
});

Form::macro('selectField', function($label, $name, $list = array(), $selected = null, $options = array(), $icon=null, $ruta=null)
{
	$data = compact('label', 'name', 'list', 'selected', 'options', 'icon', 'ruta');

	return View::make('util.form.select', $data)->render();
});

Form::macro('fileField', function($label, $name, $options = array())
{
	$data = compact('label', 'name', 'options');

	return View::make('util.form.file', $data)->render();
});

Form::macro('submitButton', function($value = null, $options = array())
{
	$data = compact('value', 'options');

	return View::make('util.form.submit', $data)->render();
});

Form::macro('deleteButton', function($value = null, $href, $message, $options = array())
{
	$options['delete'] = $href;
	$options['message'] = $message;

	$data = compact('value', 'options');

	return View::make('util.form.delete', $data)->render();
});

HTML::macro('rating', function($value, $id = 0)
{
	return '
	<span ng-app="rating" title='.$value.'>
		<span ng-init="value'.$id.' = '.round($value).'">
			<rating ng-model="value'.$id.'" readonly="true">'.round($value).'</rating>
		</span>
	</span>
	';
});

HTML::macro('listLink', function($name, $link, $ignoreLastSegments = false)
{
	$reqUrl = Request::url();
	$isLink = $reqUrl == $link;

	if ($ignoreLastSegments && !$isLink)
	{
		$isLink = strpos($reqUrl, "$link/") !== false;
	}

	$output = ($isLink) ? '<li class="active">' : '<li>';
	$output .= '<a href="'.url($link).'">'.$name.'</a></li>';

	return $output;
});

HTML::macro('buttonLink', function($name, $link, $ignoreLastSegments = false, $ignoreLastChar = false)
{
	$reqUrl = Request::url();

	$isLink = $reqUrl == $link;

	if ($ignoreLastSegments && !$isLink)
	{
		$isLink = strpos($reqUrl, "$link/") !== false;
		if ($ignoreLastChar && !$isLink)
		{
			$isLink = strpos($reqUrl, substr($link, 0, -1)."/") !== false;
		}
	}

	$output = '<a type="button" class="btn btn-lg'.($isLink ? ' active' : '').'"';
	$output .= ' href="'.url($link).'">'.$name.'</a>';

	return $output;
});