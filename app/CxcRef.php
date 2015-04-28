<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcRef extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcRef';

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
	protected $visible = ['mov','mov_id', 'emission_date', 'expiration_date', 'balance'];

	protected $appends = ['mov','mov_id', 'emission_date', 'expiration_date', 'balance'];

	public function getMovAttribute(){
		return $this->Mov;
	}

	public function getMovIdAttribute(){
		return $this->MovID;
	}

	public function getEmissionDateAttribute(){
		return $this->FechaEmision;
	}

	public function getExpirationDateAttribute(){
		return $this->Vencimiento;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}
}
