<?php

namespace Easy\Form;

class Tablebox extends Base
{

	public static function make($view, $data = [])
	{

		return self::$instance = new Tablebox($view, $data);
	}

}