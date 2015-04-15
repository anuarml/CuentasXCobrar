<?php namespace App\Services;

use App\Company;
use Validator;

class Login {

	/**
	 * Get a validator for an incoming login request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		$aCompanies = Company::all()->toArray();

		$aCompanies = array_pluck($aCompanies, 'id');

		$companies = implode(',', $aCompanies);

		return Validator::make($data, [
			'username' => 'required',
			'password' => 'required',
			'company'  => 'required|in:'.$companies,
			'office'   => 'required',
		]);
	}

	/**
	 * Logs the user after a valid data.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function login(array $data)
	{
		
	}

}