<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Usuario';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = [];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['username'];

	protected $with = [];

	protected $appends = ['username'];

	public function getUsernameAttribute(){
		return $this->Usuario;
	}

	public function getnameAttribute(){
		return $this->Nombre;
	}

	public function getAccountAttribute(){
		return $this->DefCtaDinero;
	}

	public function getnameAttribute(){
		return $this->Nombre;
	}

	public function getnameAttribute(){
		return $this->Nombre;
	}

	public function getnameAttribute(){
		return $this->Nombre;
	}

	/*public function offices(){
		return $this->hasMany('App\Office','Empresa','Empresa');
	}*/

}
