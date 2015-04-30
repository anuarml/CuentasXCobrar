<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcInfo extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcInfo';

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
	protected $visible = ['Mov','mov_id', 'expiration', 'delinquent_days', 'balance'];

	protected $appends = ['mov_id', 'expiration', 'delinquent_days', 'balance'];

	public function getMovIdAttribute(){
		return $this->MovID;
	}

	public function getExpirationAttribute(){
		return $this->Vencimiento;
	}

	public function getDelinquentDaysAttribute(){
		return $this->DiasMoratorios;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}

}
