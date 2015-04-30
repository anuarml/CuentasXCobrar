<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $primaryKey = 'Usuario';

	public $timestamps = false;

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
	protected $visible = ['username', 'name', 'account', 'cashier', 'can_cancel', 'agent', 'shipments', 'def_currency'];

	protected $with = [];

	protected $appends = ['username', 'name', 'account', 'cashier', 'can_cancel', 'agent'];

	public function getUsernameAttribute(){
		return $this->Usuario;
	}

	public function getNameAttribute(){
		return $this->Nombre;
	}

	public function getAccountAttribute(){
		return $this->DefCtaDinero;
	}

	public function getCashierAttribute(){
		return $this->DefCajero;
	}

	public function getCanCancelAttribute(){
		return $this->Cancelar;
	}

	public function getAgentAttribute(){
		return $this->DefAgente;
	}

	public function shipments(){
		return $this->hasMany('App\Shipment','Agente','DefAgente');
	}

	public function defCurrency(){
		return $this->hasOne('App\Currency','Moneda','DefMoneda');
	}

	public static function invalidCredentials(array $credentials){
		
		$invalidCredentials = 1;
		$username = $credentials['username'];
		$password = $credentials['password'];

		if($username == '' || $password == ''){
			return $invalidCredentials;
		}

		$stmt = \DB::getPdo()->prepare('EXEC spThoValidaPwdWeb ?, ?, ?');

		$stmt->bindParam(1, $username);
		$stmt->bindParam(2, $password);
		$stmt->bindParam(3, $invalidCredentials, \PDO::PARAM_INT|\PDO::PARAM_INPUT_OUTPUT, 1);

		$stmt->execute();

		return $invalidCredentials;
	}

	public function getRememberToken()
	{
		return null; // not supported
	}

	public function setRememberToken($value)
	{
		// not supported
	}

	public function getRememberTokenName()
	{
		return null; // not supported
	}

	 /**
	  * Overrides the method to ignore the remember token.
	  */
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute)
		{
		parent::setAttribute($key, $value);
		}
	}

}
