<?php

namespace Binaryk\Models\Sys;

class Route {

	protected static $instance = NULL;
	protected $routes = [];

	public function __construct() {
		$this 
			/**
				Nomenclator
			 **/  
			->add('get', 'datatable-index', 'nomenclator/{id}', 'DatatableController@index', 'Binaryk\Controllers\Datatable')
			->add('get', 'datatable-row-source', 'nomenclator/row-source/{id}', 'DatatableController@rows', 'Binaryk\Controllers\Datatable')
			->add('post', 'datatable-load-form', 'nomenclator/load-dt-form/{id}', 'DatatableController@loadForm', 'Binaryk\Controllers\Datatable')
			->add('post', 'datatable-do-action', 'nomenclator/dt-do-action/{id}', 'DatatableController@doAction', 'Binaryk\Controllers\Datatable')

			->add('get', 'nomenclator-tip-anunt', 'nomenclator/tip-anunt/{id}/{id_procedura}', 'TipAnuntController@index', 'Binaryk\Controllers\Nomenclator')
			->add('get', 'nomenclator-tip-anunt-row-source', 'nomenclator/tip-anunt/row-source/{id}/{id_procedura}', 'TipAnuntController@rows', 'Binaryk\Controllers\Nomenclator')
			
			->add('get', 'nomenclator-modalitati-publicare', 'nomenclator/modalitati-publicare/{id}/{id_anunt}', 'ModalitatiPublicareController@index', 'Binaryk\Controllers\Nomenclator')
			->add('get', 'nomenclator-modalitati-publicare-row-source', 'nomenclator/modalitati-publicare/row-source/{id}/{id_anunt}', 'ModalitatiPublicareController@rows', 'Binaryk\Controllers\Nomenclator')

			->add('post', 'get-tip-proceduri-by-achizitor', 'get-tip-proceduri-by-achizitor', 'DatabaseController@toCombobox', 'Database')
			->add('post', 'get_tip_achizitie_template_url', 'get_tip_achizitie_template_url', 'TemplateAchizitiiController@getTipAchizitiiTemplate', 'Binaryk\Controllers\Nomenclator')
			->add('post', 'get_tip_achizitii_url', 'get_tip_achizitii_url', 'DatabaseController@toCombobox', 'Database')
			

			->add('get', 'nomenclator-template-achizitii', 'nomenclator-template/{id}', 'TemplateAchizitiiController@index', 'Binaryk\Controllers\Nomenclator')
			->add('get', 'nomenclator-template-achizitii-row-source', 'nomenclator/row-source/{id}', 'DatatableController@rows', 'Binaryk\Controllers\Datatable')
		;
	}

	protected function add($method, $name, $uri, $action, $namespace) {
		$record = new \StdClass();
		$record->method = $method;
		$record->name = $name;
		$record->uri = $uri;
		$record->action = $action;
		$record->namespace = $namespace;
		$this->routes[] = $record;
		return $this;
	}

	public static function make() {
		return self::$instance = new Route();
	}

	public function define() {
		foreach ($this->routes as $i => $record) {
			\Route::{ $record->method}(
				$record->uri,
				[
					'as' => $record->name,
					'uses' => ($record->namespace ? $record->namespace . '\\' : '') . $record->action,
				]
			);
		}
	}

}