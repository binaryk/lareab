<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

routesInDirectory();

# Include toate rutele din folderul 'routes'
function routesInDirectory($app = '') {  
    $routeDir = app_path('routes/' . $app . ($app !== '' ? '/' : NULL));
    $iterator = new RecursiveDirectoryIterator($routeDir);
    $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);

    foreach ($iterator as $route) {
        $isDotFile = strpos($route->getFilename(), '.') === 0;
        if (!$isDotFile && !$route->isDir()) {
            require_once $routeDir . $route->getFilename();
        }
    }
}



/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */
Route::model('user', 'User');
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');

/** ------------------------------------------
 *  Route constraint patterns
 *  ------------------------------------------
 */
Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
    # Comment Management
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    Route::controller('comments', 'AdminCommentsController');

    # Blog Management
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow');
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');

    # User Management
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/{role}/show', 'AdminRolesController@getShow');
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    # Admin Dashboard
    Route::controller('/', 'AdminDashboardController');
});

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */

//:: Application Routes ::

# Filter for detect language
Route::when('contact-us','detectLang');

# Contact Us Static Page
Route::get('contact-us', function()
{
    // Return about us page
    return View::make('site/contact-us');
});

Route::filter('auth', function()
{
  if (Auth::check() == false)
  {
  // Notice that im using Redirect::guest instead of Redirect::to, 
  // this is to make the Redirect::intendeed work later on.
    return Redirect::guest('user/login');
  }
});

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'UserController@getLogin'));
Route::get('/create', array('before' => 'detectLang','uses' => 'UserController@getCreate'));
Route::get('/forgot', array('before' => 'detectLang','uses' => 'UserController@getForgot'));

Route::group(array('after' => 'auth'), function () {
    
    Route::group(array('after' => 'csrf'), function () {
       
        /* Organizations */
        Route::post('/organization/add', array('uses' => 'OrganizationController@postAddOrganization'));
        Route::post('/organization/edit/{id}', array('uses' => 'OrganizationController@postEditOrganization'));
        Route::post('/organization/delete', array('uses' => 'OrganizationController@postDeleteOrganization'));
               
        /*Stadii livrabile*/
        Route::post('/stadiu_livrabil_add', array('as' => 'stadiu_livrabil_add', 'uses' => 'StadiuLivrabilController@postSchimbaStadiu'));

        /*Financiar*/
        Route::post('/livrabile_nefacturate_client', array('as' => 'genereaza_desfasurator_client', 'uses' => 'LivrabileController@postGenereazaDesfasuratorClient'));
        Route::post('/livrabile_nefacturate_furnizor', array('as' => 'genereaza_desfasurator_furnizor', 'uses' => 'LivrabileController@postGenereazaDesfasuratorFurnizor'));
        
        /*Facturi client*/
        Route::post('/factura_client_edit/{id}', array('as'=>'factura_client_edit', 'uses' => 'FacturaClientController@postEditFactura'));
        Route::post('/factura_client_delete', array('as'=>'factura_client_delete', 'uses' => 'FacturaClientController@postDeleteFactura'));
        Route::post('/factura_client_detaliu_add', array('as'=>'factura_client_detaliu_add', 'uses' => 'FacturaClientController@postAddDetaliuFactura'));
        Route::post('/factura_client_detaliu_delete', array('as'=>'factura_client_detaliu_delete', 'uses' => 'FacturaClientController@postDeleteDetaliuFactura'));
        Route::post('/factura_client_detaliu_edit', array('as'=>'factura_client_detaliu_edit', 'uses' => 'FacturaClientController@postEditDetalii'));

        /*Facturi furnizor*/
        Route::post('/factura_furnizor_add', array('as'=>'factura_furnizor_add', 'uses' => 'FacturaFurnizorController@postAddFactura'));
        Route::post('/factura_furnizor_edit/{id}', array('as'=>'factura_furnizor_edit', 'uses' => 'FacturaFurnizorController@postEditFactura'));
        Route::post('/factura_furnizor_delete', array('as'=>'factura_furnizor_delete', 'uses' => 'FacturaFurnizorController@postDeleteFactura'));
        Route::post('/factura_furnizor_detaliu_add', array('as'=>'factura_furnizor_detaliu_add', 'uses' => 'FacturaFurnizorController@postAddDetaliuFactura'));
        Route::post('/factura_furnizor_detaliu_delete', array('as'=>'factura_furnizor_detaliu_delete', 'uses' => 'FacturaFurnizorController@postDeleteDetaliuFactura'));
        Route::post('/factura_furnizor_detaliu_edit', array('as'=>'factura_furnizor_detaliu_edit', 'uses' => 'FacturaFurnizorController@postEditDetalii'));

        /*Incasari facturi*/
        Route::post('/incasare_factura_add/{id}', array('as'=>'incasare_factura_add', 'uses' => 'IncasariFacturaController@postAddIncasareFactura'));
        Route::post('/incasare_factura_edit/{id}', array('as'=>'incasare_factura_edit', 'uses' => 'IncasariFacturaController@postEditIncasareFactura'));
        Route::post('/incasare_factura_delete', array('as'=>'incasare_factura_delete', 'uses' => 'IncasariFacturaController@postDeleteIncasare'));

        /*Plati facturi*/
        Route::post('/plata_factura_add/{id}', array('as'=>'plata_factura_add', 'uses' => 'PlatiFacturaController@postAddPlataFactura'));
        Route::post('/plata_factura_edit/{id}', array('as'=>'plata_factura_edit', 'uses' => 'PlatiFacturaController@postEditPlataFactura'));
        Route::post('/plata_factura_delete', array('as'=>'plata_factura_delete', 'uses' => 'PlatiFacturaController@postDeletePlata'));

        /*Livrabile etapa*/
        Route::post('/livrabile_etapa_add/{id}', array('as'=>'livrabile_etapa_add', 'uses' => 'LivrabileEtapaController@postAddLivrabilEtapa'));
        

 
        /*Contracte - optiuni*/
        Route::post('/garantie_executie/{id}', array('as' => 'garantie_executie', 'uses' => 'ContractOptiuniController@postAddEditGarantieExecutie'));
        Route::post('/garantie_participare/{id}', array('as' => 'garantie_participare', 'uses' => 'ContractOptiuniController@postAddEditGarantieParticipare'));


    
 
        /*Etape si termene*/        
        Route::post('/etapa_add/{id}', array('as'=>'etapa_add', 'uses' => 'EtapeTermeneController@postAddEtapa'));
        Route::post('/etapa_edit/{id}', array('as'=>'etapa_edit', 'uses' => 'EtapeTermeneController@postEditEtapa'));
        Route::post('/etapa_delete', array('as'=>'etapa_delete', 'uses' => 'EtapeTermeneController@postDeleteEtapa'));        

 
        /*Dosar contract*/        
        Route::post('/document_upload/{id}', array('as' => 'document_upload', 'uses' => 'DosarContractController@postUploadDocument'));
        Route::post('/document_delete', array('as' => 'document_delete', 'uses' => 'DosarContractController@postDeleteDocument'));
    });
    
    Route::get('/dashboard', array('uses' => 'HomeController@home'));
    
    /*Livrabile*/
    Route::get('/livrabile', array('uses' => 'LivrabileController@getLivrabile'));
    Route::get('/livrabile_factura/{id}', array('as' => 'livrabile_factura','uses' => 'LivrabileController@getLivrabileFactura'));

    /*Livrabile nefacturate*/
    Route::get('/livrabile_nefacturate_client', array('as' => 'livrabile_nefacturate_client', 'uses' => 'LivrabileController@getLivrabileNefacturateClient'));
    Route::get('/livrabile_nefacturate_furnizor', array('as' => 'livrabile_nefacturate_furnizor', 'uses' => 'LivrabileController@getLivrabileNefacturateFurnizor'));
    
    /*Stadii livrabile*/
    Route::get('/stadiu_livrabil/{id}', array('as' => 'stadiu_livrabil', 'uses' => 'StadiuLivrabilController@getStadii'));
    
    /*Livrabile etapa*/
    Route::get('/livrabile_etapa_list/{id}', array('as'=>'livrabile_etapa_list', 'uses' => 'LivrabileEtapaController@getLivrabile'));
    Route::get('/livrabile_etapa_add/{id}', array('as'=>'livrabile_etapa_add', 'uses' => 'LivrabileEtapaController@getAddLivrabilEtapa'));
	       
    /*Contracte*/
    Route::get('/contract/{id}', array('as' => 'contract_single', 'uses' => 'ContractController@getContractSingle'));
    Route::get('/contract_list', array('as'=>'contract_list', 'uses' => 'ContractController@getContracte'));
    Route::get('/contract_add', array('as'=>'contract_add', 'uses' => 'ContractController@getAddContract'));
    Route::get('/contract_edit/{id}', array('as'=>'contract_edit', 'uses' => 'ContractController@getEditContract'));
    Route::get('/contract_optiuni/{id}', array('as'=>'contract_optiuni', 'uses' => 'ContractController@getOptiuniContract'));

    /*Contracte - optiuni*/
    Route::get('/stadii_contract/{id}', array('as'=>'stadii_contract', 'uses' => 'ContractOptiuniController@getStadiiContract'));
    Route::get('/garantie_executie/{id}', array('as' => 'garantie_executie', 'uses' => 'ContractOptiuniController@getAddEditGarantieExecutie'));
    Route::get('/garantie_participare/{id}', array('as' => 'garantie_participare', 'uses' => 'ContractOptiuniController@getAddEditGarantieParticipare'));
    /*ruta catre obiectivele contractului este deja creata in partea de Obiective*/

 


 
    /*Etape si termene*/
    Route::get('/etapa_list/{id}', array('as'=>'etapa_list', 'uses' => 'EtapeTermeneController@getEtape'));
    Route::get('/etapa_add/{id}', array('as'=>'etapa_add', 'uses' => 'EtapeTermeneController@getAddEtapa'));
    Route::get('/etapa_edit/{id}', array('as'=>'etapa_edit', 'uses' => 'EtapeTermeneController@getEditEtapa'));

    /*Facturi furnizor*/
    Route::get('/facturi_furnizor_list', array('as'=>'facturi_furnizor', 'uses' => 'FacturaFurnizorController@getFacturi'));
    Route::get('/factura_furnizor_add', array('as'=>'factura_furnizor_add', 'uses' => 'FacturaFurnizorController@getAddFactura'));
    
    /*Facturi client*/
    Route::get('/facturi_client_list', array('as'=>'facturi_client', 'uses' => 'FacturaClientController@getFacturi'));
    Route::get('/factura_client_optiuni/{id}', array('as'=>'factura_client_optiuni', 'uses' => 'FacturaClientController@getOptiuniFactura'));
    Route::get('/factura_client_edit/{id}', array('as'=>'factura_client_edit', 'uses' => 'FacturaClientController@getEditFactura'));
    Route::get('/detalii_factura_client/{id}', array('as'=>'detalii_factura_client', 'uses' => 'FacturaClientController@getDetaliiFactura'));

    /*Facturi furnizor*/
    Route::get('/facturi_furnizor_list', array('as'=>'facturi_furnizor', 'uses' => 'FacturaFurnizorController@getFacturi'));
    Route::get('/factura_furnizor_optiuni/{id}', array('as'=>'factura_furnizor_optiuni', 'uses' => 'FacturaFurnizorController@getOptiuniFactura'));
    Route::get('/factura_furnizor_edit/{id}', array('as'=>'factura_furnizor_edit', 'uses' => 'FacturaFurnizorController@getEditFactura'));
    Route::get('/detalii_factura_furnizor/{id}', array('as'=>'detalii_factura_furnizor', 'uses' => 'FacturaFurnizorController@getDetaliiFactura'));

    /*Incasari facturi*/
    Route::get('/incasari_factura/{id}', array('as'=>'incasari_factura', 'uses' => 'IncasariFacturaController@getIncasariFactura'));
    Route::get('/incasare_factura_add/{id}', array('as'=>'incasare_factura_add', 'uses' => 'IncasariFacturaController@getAddIncasareFactura'));
    Route::get('/incasare_factura_edit/{id}', array('as'=>'incasare_factura_edit', 'uses' => 'IncasariFacturaController@getEditIncasareFactura'));
    
    /*Plati facturi*/
    Route::get('/plati_factura/{id}', array('as'=>'plati_factura', 'uses' => 'PlatiFacturaController@getPlatiFactura'));
    Route::get('/plata_factura_add/{id}', array('as'=>'plata_factura_add', 'uses' => 'PlatiFacturaController@getAddPlataFactura'));
    Route::get('/plata_factura_edit/{id}', array('as'=>'plata_factura_edit', 'uses' => 'PlatiFacturaController@getEditPlataFactura'));



   
    /* Users */
    Route::get('/users', array('uses' => 'UserController@getUsers'));
    Route::get('/user/add', array('uses' => 'UserController@getAddUser'));
    Route::get('/user/edit/{id}', array('uses' => 'UserController@getEditUser'));
    Route::get('/user/{id}', array('uses' => 'UserController@getUser'));
    
    /* Projects */
    Route::get('/projects', array('uses' => 'ProjectController@getProjects'));
    Route::get('/project/add', array('uses' => 'ProjectController@getAddProject'));
    Route::get('/project/edit/{id}', array('uses' => 'ProjectController@getEditProject'));
    Route::get('/project/{id}', array('uses' => 'ProjectController@getProject'));
    
    /* Organizations */
    Route::get('/organizations', array('uses' => 'OrganizationController@getOrganizations'));
    Route::get('/organization/add', array('uses' => 'OrganizationController@getAddOrganization'));
    Route::get('/organization/edit/{id}', array('uses' => 'OrganizationController@getEditOrganization'));
    Route::get('/organization/{id}', array('uses' => 'OrganizationController@getOrganization'));
    
    /* Teams */
    Route::get('/teams', array('uses' => 'TeamController@getTeams'));
    Route::get('/team/add', array('uses' => 'TeamController@getAddTeam'));
    Route::get('/team/edit/{id}', array('uses' => 'TeamController@getEditTeam'));
    Route::get('/team/{id}', array('uses' => 'TeamController@getTeam'));


    /*Imobile-asociatii*/
    Route::get('/imobile_asociatii_list', array('as' => 'imobile_asociatii', 'uses' => 'ImobileAsociatiiController@getImobile'));
    
    /*Dosar contract*/
    Route::get('/document_list/{id}', array('as' => 'document_list', 'uses' => 'DosarContractController@getDocumente'));
    Route::get('/document_upload/{id}', array('as' => 'document_upload', 'uses' => 'DosarContractController@getUploadDocument'));
    Route::get('/document_download/{filename}/{guid}/{id}', array('as' => 'document_download', 'uses' => 'DosarContractController@postDownloadDocument'));

    Route::get('/logins', array('uses' => 'LoginsController@getLogins'));

    /*Utils*/
    Route::get('/genereaza_segmentare', array('uses' => 'UtilController@genereazaSegmentareGeografica'));
    //Route::get('/admin/genereaza_serii', array('uses' => 'UtilController@genereazaSeriiFacturare'));
});

