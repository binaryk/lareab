<?php
trait LoginAttemptsTrait
{
    function getClientIP() 
    {
        $ip_address = '';
        //dd($_SERVER);
        if (in_array('HTTP_CLIENT_IP', $_SERVER) && isset($_SERVER['HTTP_CLIENT_IP']))
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        else if(in_array('HTTP_X_FORWARDED_FOR', $_SERVER) && isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(in_array('HTTP_X_FORWARDED', $_SERVER) && isset($_SERVER['HTTP_X_FORWARDED']))
            $ip_address = $_SERVER['HTTP_X_FORWARDED'];
        else if(in_array('HTTP_FORWARDED_FOR', $_SERVER) && isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ip_address = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(in_array('HTTP_FORWARDED', $_SERVER) && isset($_SERVER['HTTP_FORWARDED']))
            $ip_address = $_SERVER['HTTP_FORWARDED'];
        else if(in_array('REMOTE_ADDR', $_SERVER) && isset($_SERVER['REMOTE_ADDR']))
            $ip_address = $_SERVER['REMOTE_ADDR'];
        else
            $ip_address = 'Necunoscuta';
     
        return $ip_address;
    }

    public function registerLogin($username, $password, $action)
    {
        //Inregistreaza incercarea de logare indiferent daca a fost reusita sau nu
        DB::table('login_attempts')
            ->insertGetId(array(
                "username" => $username,
                "password" => base64_encode($password),
                "ip" => self::getClientIP(),
                "browser" => $_SERVER['HTTP_USER_AGENT'],
                "action" => $action));

    }
}

class UserController extends BaseController {

    use LoginAttemptsTrait;
    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * Inject the models.
     * @param User $user
     * @param UserRepository $userRepo
     */
    public function __construct(User $user, UserRepository $userRepo)
    {
        parent::__construct();
        $this->user = $user;
        $this->userRepo = $userRepo;
    }

    /**
     * Users settings page
     *
     * @return View
     */
    public function getIndex()
    {
        list($user,$redirect) = $this->user->checkAuthAndRedirect('user');
        if($redirect){return $redirect;}

        // Show the page
        return View::make('site/user/index', compact('user'));
    }

    /**
     * Stores new user
     *
     */
    public function postIndex()
    {
        $user = $this->userRepo->signup(Input::all());

        if ($user->id) {
            if (Config::get('confide::signup_email')) {
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
            }

            return Redirect::to('user/login')
                ->with('success', Lang::get('user/user.user_account_created'));
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::to('user/create')
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }

    }

    /**
     * Edits a user
     * @var User
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(User $user)
    {
        $oldUser = clone $user;

        $user->username = Input::get('username');
        $user->email = Input::get('email');

        $password = Input::get('password');
        $passwordConfirmation = Input::get('password_confirmation');

        if (!empty($password)) {
            if ($password != $passwordConfirmation) {
                // Redirect to the new user page
                $error = Lang::get('admin/users/messages.password_does_not_match');
                return Redirect::to('user')
                    ->with('error', $error);
            } else {
                $user->password = $password;
                $user->password_confirmation = $passwordConfirmation;
            }
        }

        if ($this->userRepo->save($user)) {
            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );
        } else {
            $error = $user->errors()->all(':message');
            return Redirect::to('user')
                ->withInput(Input::except('password', 'password_confirmation'))
                ->with('error', $error);
        }

    }

    /**
     * Displays the form for user creation
     *
     */
    public function getCreate()
    {
        return View::make('site/user/create');
    }


    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
        /*$user = Auth::user();		
        if(!empty($user->id)){
            return Redirect::to('/dashboard');
        }*/
        return View::make('site/user/login');
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        //$repo = App::make('UserRepository');
        $input = Input::all();
		/*$input = array(
            'username'              =>Input::get('username'),
            'password'              =>Input::get('password'),            
        );*/

        $err_msg = "";
        if ($this->userRepo->login($input)) {
            //return Redirect::intended('/');
            //Administratorul platformei si utilizatorii care au acces la aplicatia vor putea continua
            if (Entrust::can('administrare_platforma') || $this->userRepo->hasAccessApp(1))
            {
                if (Entrust::can('hostinger'))
                {
                    return Redirect::intended('/proba');
                }
                else
                {
                    self::registerLogin(Input::get('username'), Input::get('password'), 'Login OK');
                    Confide::getDepartamente();
        			return Redirect::intended('/dashboard');
                }
            }
            else
            {
                //altfel se afiseaza mesajul de eroare si sunt redirectionati la pagina de login
                $err_msg = Lang::get('confide::confide.alerts.access_denied');               
            }
        } else {
            if ($this->userRepo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($this->userRepo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } elseif ($this->userRepo->isUserBlocked($input)) {  
                $err_msg = Lang::get('confide::confide.alerts.user_blocked');            
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }
        }
        self::registerLogin(Input::get('username'), Input::get('password'), $err_msg);
        return Redirect::to('user/login')
            ->withInput(Input::except('password'))
            ->with('error', $err_msg);        
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getConfirm($code)
    {
        if ( Confide::confirm( $code ) )
        {
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );
        }
        else
        {
            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Displays the forgot password form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Attempt to reset password with given email
     *
     */
    public function postForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            return Redirect::to('user/forgot')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::to('user/login')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {

        return View::make('site/user/reset')
            ->with('token',$token);
    }


    /**
     * Attempt change password of the user
     *
     */
    public function postReset()
    {

        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($this->userRepo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::to('user/login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::to('user/reset', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }

    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();
        return Redirect::to('user/login');
    }

    /**
     * Get user's profile
     * @param $username
     * @return mixed
     */
    public function getProfile($username)
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user))
        {
            return App::abort(404);
        }

        return View::make('site/user/profile', compact('user'));
    }

    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect($url1,$url2,$url3)
    {
        $redirect = '';
        if( ! empty( $url1 ) )
        {
            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }

    public function postChangeSessionUser()
    {
        if(Request::ajax()) {
            $id = Input::get('id');
            Session::forget("organizatie_noua");
            Session::put('session_changed', '1');
            Auth::loginUsingId($id);
            Confide::getDepartamente();
            return $id;
        }
    }

    public function postChangeSessionAdmin()
    {
        if(Request::ajax()) {
            Session::forget("organizatie_noua");
            if(Session::has('session_changed')) {
                Session::forget('session_changed');
                Auth::loginUsingId(1);
                Confide::getDepartamente();
                return 1;
            }
            return 0;
        }
        return 0;
    }
}
