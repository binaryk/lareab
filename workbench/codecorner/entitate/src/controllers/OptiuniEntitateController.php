<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class OptiuniEntitateController extends \BaseController
{
    public function getOptiuniEntitate($id) 
    {
        $entitate = DB::select("SELECT
            ent.id, 
            ent.denumire as entitate,
            loc.denumire as localitate            
            
        FROM entitate ent
        LEFT OUTER JOIN localitate loc ON loc.id_localitate = ent.id_localitate AND loc.logical_delete = 0        
        WHERE ent.logical_delete = 0 
        AND ent.id = :id", array('id' => $id));

        return View::make('entitate::optiuni_entitate.options')->with('entitate', $entitate);
    }
}