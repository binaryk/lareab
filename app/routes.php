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

require "macros.php";


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
    Route::get('users/list', 'AdminUsersController@getUsers');
    /*Route::get('users/edit/{id}', array('as' => 'user_edit','uses' => 'AdminUsersController@getEdit'));
    Route::get('users/add', array('as' => 'user_add','uses' => 'AdminUsersController@getAddUser'));
    Route::post('users/add', array('as' => 'user_add','uses' => 'AdminUsersController@postAddUser'));
    */
    
    Route::get('/departamente_utilizator/{id}', array('as' => 'departamente_utilizator/{id}', 'uses' => 'AdminDepartamenteController@AdaugaDepartamente')); 
    
    Route::post('user_lock', array('as' => 'user_lock','uses' => 'AdminUsersController@postLockUser'));

    Route::get('users/create', 'AdminUsersController@getCreate');
    Route::post('users/create', 'AdminUsersController@postCreate');
    Route::get('users/{user}/show', 'AdminUsersController@getShow');
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
  
    Route::controller('users', 'AdminUsersController');

    # User Role Management
    Route::get('roles/list', 'AdminRolesController@getRoles');
    Route::get('roles/create', 'AdminRolesController@getCreate');
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
Route::get('/proba', array('before' => 'detectLang','uses' => 'UserController@getError'));

Route::group(array('after' => 'auth'), function () {
        
    Route::get('/dashboard', array('uses' => 'HomeController@home'));
    
    /*Livrabile*/
    Route::get('/livrabile', array('uses' => 'LivrabileController@getLivrabile'));
    Route::get('/livrabile_factura/{id}', array('as' => 'livrabile_factura','uses' => 'LivrabileController@getLivrabileFactura'));  
    
	Route::post('/salveaza_departamente_utilizator', array('as' => 'salveaza_departamente_utilizator', 'uses' => 'AdminDepartamenteController@SalveazaAdaugaDepartamente'));

    Route::get('/logins', array('uses' => 'LoginsController@getLogins'));    

    /*Utils*/
    Route::get('/genereaza_segmentare', array('uses' => 'UtilController@genereazaSegmentareGeografica'));   
});

Entrust::routeNeedsPermission( 'admin/users*', 'manage_users', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'admin/roles*', 'manage_roles', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'factur*', 'manage_finance', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'detalii_factura*', 'manage_finance', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'livrabile_nefacturate*', 'manage_finance', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'incasar*', 'manage_finance', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'registru_intrare*', 'manage_registru_intrare', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'registru_iesire*', 'manage_registru_iesire', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'investitie_por_axa12_list', 'list_por_axa12', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'investitie_por_axa12_edit', 'edit_por_axa12', Response::view('error.403', [], 403));
Entrust::routeNeedsPermission( 'investitie_por_axa12_add', 'add_por_axa12', Response::view('error.403', [], 403));