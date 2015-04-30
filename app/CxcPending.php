<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcPending extends Model {

	class Company extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcPendiente';

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
	protected $visible = ['Mov','mov_id', 'balance', 'total_amount', 'expiration', 'emission_date'];

	protected $appends = ['mov_id', 'balance', 'total_amount', 'expiration', 'emission_date'];

	public function getMovIdAttribute(){
		return $this->MovID;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}

	public function getTotalAmountAttribute(){
		return $this->ImporteTotal;
	}

	public function getExpirationAttribute(){
		return $this->Vencimiento;
	}

	public function getEmissionDateAttribute(){
		return $this->FechaEmision;
	}
}
