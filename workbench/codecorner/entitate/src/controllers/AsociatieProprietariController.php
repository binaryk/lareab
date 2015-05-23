<?php namespace Codecorner\Entitate\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class AsociatieProprietariController extends \BaseController
{
	public function getAsociatiiProprietari()
	{
		$asociatii = DB::select("SELECT
			ap.id_asociatie,
			ap.denumire,
			ap.strada,
			ap.numar,
			ap.bloc,
			ap.scara,
			judet.denumire AS judet,
			loc.denumire as localitate
			FROM asociatie_proprietari ap
			LEFT OUTER JOIN judet ON judet.id_judet = ap.id_judet AND judet.logical_delete = 0
			LEFT OUTER JOIN v_localitate_descriere loc ON loc.id_localitate = ap.id_localitate
			WHERE ap.id_organizatie = :id_organizatie", array('id_organizatie' => $this->date_organizatie[0]->id_organizatie));
		return View::make('entitate::asociatie_proprietari.list')
            ->with('asociatii', $asociatii);  						
	}

	public function getAddAsociatieProprietari()
	{
		return View::make('entitate::asociatie_proprietari.add');
	}
}