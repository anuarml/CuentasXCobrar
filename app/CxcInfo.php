<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcInfo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcInfo';

	protected $dates =['Vencimiento'];
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
	protected $visible = ['Mov','MovID', 'expiration', 'delinquent_days', 'balance'];

	protected $appends = ['expiration', 'delinquent_days', 'balance'];

	public function getExpirationAttribute(){
		return $this->Vencimiento->__toString();
	}

	public function getDelinquentDaysAttribute(){
		return $this->DiasMoratorios;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}

}
