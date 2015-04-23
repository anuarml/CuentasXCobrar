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
	protected $visible = ['mov','mov_id', 'expiration', 'delinquent_days', 'balance'];

	protected $appends = ['mov','mov_id', 'expiration', 'delinquent_days', 'balance'];

	public function getMovAttribute(){
		return $this->Mov;
	}

	public function getMovIdAttribute(){
		return $this->MOVID;
	}

	public function getExpirationAttribute(){
		return $this->Vencimiento;
	}

	public function getDelinquentDaysAttribute(){
		return $this->DIASMORATORIOS;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}

}
