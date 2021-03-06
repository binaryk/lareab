<?php

namespace Datatable;

class DatatableController extends \BaseController 
{

    /**
     * @param $config - array cu particularitati primit din functia toIndexConfig a clasei Grids
     * @throws \Exception
     */
    public function show($config)
	{
		if( empty($config['view']) )
		{
			throw new \Exception(__METHOD__ . '. View parameter not defined.');
		}
		if( empty($config['name']) )
		{
			throw new \Exception(__METHOD__ . '. Javascript datatable variable name not defined.');
		}
		$other_info = array_key_exists('other-info', $config) ? $config['other-info'] : [];
		$this->layout->title = strip_tags($config['caption']);  
		$this->layout->breadcrumbs = $config['breadcrumbs'];
		$this->layout->right_menu = $config['right_menu'];;
		if( ! $config['form']  )
		{
			$form = NULL;
		}
		else
		{
			$form = $config['form']::make()->other_info($other_info);
		}
		$this->layout->content = \View::make($config['view'])->with([
			'dt'   		=> Table::create($config),
			'toolbar' 	=> \View::make($config['toolbar'])->with($other_info)->render(),
			'form'      => $form,
			'title' 	=> $this->layout->title
		] + $other_info);


	}

	public function dataset($config)
	{
		return Dataset::response($config);
	}

	protected function model($model)
	{
		return str_replace('|', '\\', $model);
	}

	protected function caption($caption, $record)
	{
		return $record ? str_replace(':id:', $record->id, $caption) : $caption;
	}

	/**
	Returneaza proprietatile pentru afisarea formularului insert/update/delete in functie de actiunea solicitata.
	Proprietatile sunt: 
		1) actiunea (insert/update/delete)
		2) caption
		3) text button submit
	**/
	public function get_dtform_properties( $form, $input )
	{
		$model    = $this->model($input['model']);
		$record   = $input['action'] != 'insert' ? $model::getRecord( $input['record_id'] ) : NULL;
		return \Response::json([
			'action'  => $input['action'],
			'caption' => $this->caption( $form->captions->{$input['action']}, $record ),
			'button'  => $form->buttons->{$input['action']},
			'record'  => $record
		]);
	}

	/**
	Declanseaza la nivelul DB actiunea de insert/update/delete
	**/
	public function do_action( $form, $input )
	{
		return 
			\Database\Actions::make()
			->model( $this->model($input['model']) )
			->data($input['data'])
			->action($input['action'])
			->record_id($input['record_id'])
			->form($form)
			->execute();
	}

} 