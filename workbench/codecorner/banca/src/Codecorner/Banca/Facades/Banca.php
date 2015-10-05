<?php namespace Codecorner\Banca\Facades;

use Illuminate\Support\Facades\Facade;

class Banca extends Facade {
   protected static function getFacadeAccessor() { return 'banca'; }
}