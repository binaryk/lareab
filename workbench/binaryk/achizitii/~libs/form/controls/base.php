<?php

namespace Easy\Form;

class Base extends \Easy\HTML\HTML
{
	
	const FEEDBACK_SUCCESS = 'success';
	const FEEDBACK_WARNING = 'warning';
	const FEEDBACK_ERROR   = 'error';

	protected static $instance = NULL;
	
	protected $data = 
		[
			'addon'          => ['before' => '@', 'after' => '#'],
			'buttonclass'    => '',
			'options'        => [],
			'caption'        => '',
			'checked'        => false,
			'controlsource'  => NULL,
			'controltype'    => NULL,
			'class'          => '',
			'cols'           => NULL,
			'recordid'       => NULL,
			'enabled'        => true,
			'feedback'       => '',
			'groupsize'      => '',
			'help'           => '',
			'maxlength'      => NULL,
			'multiple'       => false,
			'name'           => '',
			'model'          => '',
			'placeholder'    => '',
			'rows'           => '',
			'readonly'       => false,
			'style'          => '',
			'tabindex'       => '',
			'value'          => NULL,
		];
	
	public static function make($view, $data = [])
	{
		return self::$instance = new Base($view, $data);
	}

	protected function attributes()
	{
		$result = [];
		if($this->class)
		{
			$result['class'] = $this->class;
		}
		if($this->style)
		{
			$result['style'] = $this->style;
		}
		if( ! $this->enabled)
		{
			$result['disabled'] = 'disabled';
		}
		if( $this->readonly )
		{
			$result['readonly'] = 'readonly';
		}
		if($this->placeholder)
		{
			$result['placeholder'] = $this->placeholder;
		}
		if($this->tabindex)
		{
			$result['tabindex'] = $this->tabindex;
		}
		if($this->maxlength)
		{
			$result['maxlength'] = $this->maxlength;
		}
		if($this->name)
		{
			$result['id'] = $this->name;
		}
		if($this->rows)
		{
			$result['rows'] = $this->rows;
		}
		if($this->cols)
		{
			$result['cols'] = $this->cols;
		}
		if($this->multiple)
		{
			$result['multiple'] = 'multiple';
		}
		if($this->controlsource)
		{
			$result['data-control-source'] = $this->controlsource;
		}
		if($this->controltype)
		{
			$result['data-control-type'] = $this->controltype;
		}
		if($this->recordid)
		{
			$result['data-record-id'] = $this->recordid;	
		}
		if($this->model)
		{
			$result['data-model'] = $this->model;	
		} 
		return $result;
	}

	protected function beforeOut()
	{
		$this->with('attributes', $this->attributes());
	}
}