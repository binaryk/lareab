<?php namespace Codecorner\UpDownGallery\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class DosarContractController extends \BaseController
{
	private $contract = null;
	public function __construct()
	{
		$this->contract = new \ContractController;
	}

	public function getDocumente($id_contract)
	{
		$contract = $this->contract !== null ? $this->contract->getContract($id_contract) : null;
		$documente = DB::select("SELECT
			dc.id_file,
			dc.filename,
			dc.filetype,
			dc.size,
			dc.observatii,
			dc.guid,
			users.full_name as utilizator
			FROM dosar_contract dc
			LEFT OUTER JOIN users ON users.id = dc.id_user
			WHERE dc.logical_delete = 0");
		return View::make('up-down-gallery::dosar_contract.list')
			->with('contract', $contract)
			->with('documente', $documente);
	}

	public function getUploadDocument($id_contract)
	{
		return View::make('up-down-gallery::dosar_contract.upload')
			->with('id_contract', $id_contract);
	}

	public function postUploadDocument($id_contract)
	{				
		$input = Input::all();
		$rules = array(
		    'file' => 'required',
		    'observatii' => 'required',
		);
		$errors = array('required' => 'Camp obligatoriu');

		$validator = Validator::make($input, $rules);
		if ($validator->fails())
		{
			return Redirect::back()
				->with('message', 'Eroare validare formular!')
				->withErrors($validator)
				->withInput()
				->with($errors);
		}

		$upload_success = false;
		$file = '';
		$extension = '';
		$original_name = '';
		$size = 0;
		$filename = '';
		$observatii = Input::get('observatii');
		
		if (intval($id_contract) > 0)
		{			
			if (Input::hasFile('file'))
			{
			    if (Input::file('file')->isValid())
				{
					$file = Input::file('file');
	        		$extension = $file->getClientOriginalExtension();
	        		$original_name = $file->getClientOriginalName();
	        		$size = $file->getSize();

	        		$directory = public_path() . '/uploads/' . $id_contract;
			        $filename = sha1(time().time()).".{$extension}";

			    	$upload_success = $file->move($directory, $filename);
				}
				else return Redirect::back()->with('message', 'Erroare urcare document F2 (fisier invalid)!')->withInput();
			}
			else return Redirect::back()->with('message', 'Eroare urcare document F1!')->withInput();
		}
		else return Redirect::back()->with('message', 'Eroare numar contract!')->withInput();


        if( $upload_success ) 
        {
        	try {
                DB::table('dosar_contract')
                	->insertGetId(array(
                    'filename' => $original_name, 
                    'filetype' => $extension, 
                    'size' => $size,
                    'observatii' => $observatii,
                    'id_contract' => $id_contract,
                    'id_user' => Auth::id(),
                    'guid' => $filename));
            }
            catch(Exception $e) {
                return Redirect::back()->with('message', 'Eroare salvare date: ' . $e)->withInput();
            }
            return Redirect::back()->with('message', 'Salvare realizata cu succes!')->withInput();
        } 
        else 
        {
        	return Response::json('error', 400);
        }
	}

	public function postDownloadDocument($filename, $guid, $id_contract)
	{
		$directory = public_path() . '/uploads/' . $id_contract . '/';
		if(is_file($directory . $guid)) 
		{
			header('Content-Disposition: attachment; filename='.basename($filename));
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Transfer-Encoding: binary');
			header('Connection: Keep-Alive');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' .filesize($directory . $guid));
			readfile($directory . $guid);
		}
		else
		return Redirect::back()->withErrors(array('Acest fisier nu mai exista pe server'));
	}
}