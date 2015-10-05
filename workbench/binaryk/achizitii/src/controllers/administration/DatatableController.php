<?php

namespace Binaryk\Controllers\Datatable;

class DatatableController extends \Datatable\DatatableController
{
	protected $layout 		= 'achizitii::~layout.master';

    /**
     * @param $id
     * @throws \Exception
     */
    public function index($id)
	{ 
        $this->show( \Binaryk\Models\Sys\Grids::make($id)->toIndexConfig($id) );
	} 
    /**
     * @param $id
     * @return mixed
     */
    public function rows($id)
	{
		return $this->dataset( \Binaryk\Models\Sys\Grids::make($id)->toRowDatasetConfig($id) );
	}

    /**
     * @param $id
     * @return mixed
     */
    public function loadForm($id)
	{
		return $this->get_dtform_properties( \Binaryk\Models\Sys\Forms::make($id)->toFormConfig($id), \Input::all() );
	}

    /**
     * @return mixed
     */
    public function doAction()
	{
		return $this->do_action(\Binaryk\Models\Sys\Forms::make($id = \Input::get('code') )->toActionConfig($id), \Input::all() );
	}
}