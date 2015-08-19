<?php

class AdminUsersController extends AdminController {


    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    /**
     * Permission Model
     * @var Permission
     */
    protected $permission;

    /**
     * Inject the models.
     * @param User $user
     * @param Role $role
     * @param Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    /*public function getIndex()
    {
        // Title
        $title = Lang::get('admin/users/title.user_management');

        // Grab all the users
        $users = $this->user;
        // Show the page
        return View::make('admin/users/index', compact('users', 'title'));
        //return View::make('admin/users/list', compact('users', 'title'));
    }*/

    public function getUsers($id_departament = null)
    {        
        $sql = "SELECT
            u.id,
            u.username,
            u.email,
            CASE
                WHEN u.confirmed = 1 THEN 'DA'
                ELSE 'NU'
            END AS confirmed_da_nu,
            u.confirmed,
            CASE
                WHEN u.blocked = 1 THEN 'DA'
                ELSE 'NU'
            END AS blocked_da_nu,
            u.blocked,
            date_format(u.created_at,'%d-%m-%Y %H:%i') AS created_at,
            u.full_name,
            (SELECT group_concat(denumire) 
                FROM departament
                INNER JOIN users_departament ud2 ON ud2.id_departament = departament.id AND ud2.logical_delete = 0
                INNER JOIN users u2 ON u2.id =  ud2.id_user
                WHERE departament.logical_delete = 0
                AND u2.id = u.id) AS departamente,
            (SELECT group_concat(roles.name)
                FROM assigned_roles ar
                INNER JOIN roles ON roles.id = ar.role_id
                WHERE ar.user_id = u.id) AS grupuri
            FROM users u";       
        $users = null;
        if ($id_departament)
        {
            $sql = $sql .  " INNER JOIN users_departament ud ON ud.id_user = users.id AND ud.logical_delete = 0 AND ud.id_departament = :id_departament";
            $users = DB::select($sql, array('id_departament' => $id_departament));
        }
        else $users = DB::select($sql);
        return View::make('admin/users/list', compact('users'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {  
        // All roles
        $roles = $this->role->all();

        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected groups
        $selectedRoles = Input::old('roles', array());

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

		// Title
		$title = Lang::get('admin/users/title.create_a_new_user');

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/users/create_edit', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
        //return View::make('admin/users/add', compact('roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
        $this->user->username = Input::get( 'username' );
        $this->user->email = Input::get( 'email' );
        $this->user->password = Input::get( 'password' );
        $this->user->full_name = Input::get( 'full_name' );
        
        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $this->user->password_confirmation = Input::get( 'password_confirmation' );

        // Generate a random confirmation code
        $this->user->confirmation_code = md5(uniqid(mt_rand(), true));

        if (Input::get('confirm')) {
            $this->user->confirmed = Input::get('confirm');
        }

        // Permissions are currently tied to roles. Can't do this yet.
        //$user->permissions = $user->roles()->preparePermissionsForSave(Input::get( 'permissions' ));

        // Save if valid. Password field will be hashed before save
        $this->user->save();        
        $errors = $this->user->errors();

        if ( $this->user->id ) {
            // Save roles. Handles updating.
            $this->user->saveRoles(Input::get( 'roles' ));

            //Dezactivat temporar la cererea Ralucai Giurgiu
            /*if (Config::get('confide::signup_email')) {
                $user = $this->user;
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }*/

            // Redirect to the new user page
            return Redirect::to('admin/users/' . $this->user->id . '/edit')
            //return Redirect::back()->withInput()
            //return Redirect::to('admin/users/list')
                ->with('success', Lang::get('admin/users/messages.create.success'));

        } else {

            // Get validation errors (see Ardent package)
            //$error = $this->user->errors()->all();
            $errors = $this->user->errors();
            //dd($errors);
            return Redirect::to('admin/users/create')
            //return Redirect::back()
                ->withInput(Input::except('password'))
                ->with('error', Lang::get('admin/users/messages.create.error'))
                ->with( 'errors', $errors );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function getShow($user)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */

    /*public function getEdit($id_user)
    {
        $userModel = new User;
        $user = $userModel->getUserByID($id_user);

        if ( $user->id )
        {
            $roles = $this->role->all();
            $permissions = $this->permission->all();

            // Title
            $title = Lang::get('admin/users/title.user_update');
            // mode
            $mode = 'edit';

            return View::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
        }
    }*/

    public function getEdit($user)
    {
        if ( $user->id )
        {
            $roles = $this->role->all();
            $permissions = $this->permission->all();

            // Title
        	$title = Lang::get('admin/users/title.user_update');
        	// mode
        	$mode = 'edit';

        	return View::make('admin/users/create_edit', compact('user', 'roles', 'permissions', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/users/list')->with('error', Lang::get('admin/users/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @return Response
     */
    public function postEdit($user)
    {
        $oldUser = clone $user;
        $user->username = Input::get( 'username' );
        $user->email = Input::get( 'email' );
        $user->confirmed = Input::get( 'confirm' );
        $user->full_name = Input::get( 'full_name' );

        $password = Input::get( 'password' );
        $passwordConfirmation = Input::get( 'password_confirmation' );

        if(!empty($password)) {
            if($password === $passwordConfirmation) {
                $user->password = $password;
                // The password confirmation will be removed from model
                // before saving. This field will be used in Ardent's
                // auto validation.
                $user->password_confirmation = $passwordConfirmation;
            } else {
                // Redirect to the new user page                
                return Redirect::to('admin/users/' . $user->id . '/edit')
                    ->with('error', Lang::get('admin/users/messages.password_does_not_match'));                    
            }
        }
            
        if($user->confirmed == null) {
            $user->confirmed = $oldUser->confirmed;
        }

        if ($user->save()) {
            // Save roles. Handles updating.
            $user->saveRoles(Input::get( 'roles' ));
        } else {
            $errors = $user->errors();
            return Redirect::to('admin/users/' . $user->id . '/edit')
                ->with('error', Lang::get('admin/users/messages.edit.error'))
                ->with( 'errors', $errors );
        }

        // Get validation errors (see Ardent package)
        //$errors = $user->errors()->all();
        $errors = $user->errors();
        if($errors->count() == 0) {
            // Redirect to the new user page
            return Redirect::to('admin/users/' . $user->id . '/edit')
                ->with('success', Lang::get('admin/users/messages.edit.success'));
        } else {
            return Redirect::to('admin/users/' . $user->id . '/edit')
                ->with('error', Lang::get('admin/users/messages.edit.error'))
                ->with( 'errors', $errors );
        }
    }

    /**
     * Remove user page.
     *
     * @param $user
     * @return Response
     */
    public function getDelete($user)
    {
        // Title
        $title = Lang::get('admin/users/title.user_delete');

        // Show the page
        return View::make('admin/users/delete', compact('user', 'title'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param $user
     * @return Response
     */
    public function postDelete($user)
    {
        // Check if we are not trying to delete ourselves
        if ($user->id === Confide::user()->id)
        {
            // Redirect to the user management page
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.impossible'));
        }

        AssignedRoles::where('user_id', $user->id)->delete();

        $id = $user->id;
        $user->delete();

        // Was the comment post deleted?
        $user = User::find($id);
        if ( empty($user) )
        {
            // TODO needs to delete all of that user's content
            return Redirect::to('admin/users')->with('success', Lang::get('admin/users/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.error'));
        }
    }

    public function postLockUser() {        
        if (Request::ajax()) {
            if (Session::token() === Input::get('_token')) {
                //dd('token ok');
                $id = Input::get('id');

                $affected = DB::table('users')
                    ->where('id', $id)
                    ->update(array('blocked' => DB::raw('not blocked')));
                    dd($affected);
                return $id;
            }
            else dd('token ko');
        }
    }    

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $users = User::leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
                    ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
                    ->select(array('users.id', 'users.username','users.email', 'roles.name as rolename', 'users.confirmed', 'users.created_at'));

        return Datatables::of($users)
        // ->edit_column('created_at','{{{ Carbon::now()->diffForHumans(Carbon::createFromFormat(\'Y-m-d H\', $test)) }}}')

        ->edit_column('confirmed','@if($confirmed)
                            Yes
                        @else
                            No
                        @endif')

        ->add_column('actions', '<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-default">{{{ Lang::get(\'button.edit\') }}}</a>
                                @if($username == \'admin\')
                                @else
                                    <a href="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger">{{{ Lang::get(\'button.delete\') }}}</a>
                                @endif
            ')

        ->remove_column('id')

        ->make();
    }
}
