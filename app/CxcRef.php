<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcRef extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcRef';
	protected $dates =['FechaEmision', 'Vencimiento'];

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
	protected $visible = ['Mov','MovID', 'emission_date', 'expiration_date', 'balance'];

	protected $appends = ['emission_date', 'expiration_date', 'balance'];

	public function getEmissionDateAttribute(){
		return $this->FechaEmision->formatLocalized('%d/%b/%Y');;
	}

	public function getExpirationDateAttribute(){
		return $this->Vencimiento->formatLocalized('%d/%b/%Y');;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}
}
