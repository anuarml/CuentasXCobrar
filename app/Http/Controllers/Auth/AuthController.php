<?php namespace App\Http\Controllers\Auth;

use App\Company;
use App\User;
use App\Http\Controllers\Controller;
use App\Services\Login;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Get the failed login message.
	 *
	 * @return string
	 */
	protected function getFailedLoginMessage()
	{
		return 'Usuario y/o contraseña incorrecto.';
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogin()
	{
		$companies = Company::all();

		return view('auth.login')->withCompanies($companies);
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request, Login $login)
	{
		$validator = $login->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$credentials = $request->only('username', 'password');

		if( User::invalidCredentials($credentials) )
		{
			return redirect($this->loginPath())
					->withInput($request->except('password'))
					->withErrors([
						'username' => $this->getFailedLoginMessage(),
					]);
		}

		$user = User::where('Usuario', $request->get('username') )->first();
		\Auth::login($user);

		// Documentos que puede cobrar el usuario.
		if(!$user->fillUserWebAccess()){
			Log::warning('No se pudieron llenar los permisos del usuario.');
		}

		//\Session::put('company', $request->get('company'));
		//\Session::put('office', $request->get('office'));
		$user->setSelectedCompany($request->get('company'));
		$user->setSelectedOffice($request->get('office'));

		return redirect()->intended($this->redirectPath());
	}
}
