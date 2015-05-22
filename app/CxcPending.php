<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcPending extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcPendiente';

	protected $dates =['Vencimiento', 'FechaEmision'];

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
	protected $visible = ['Mov','MovID', 'balance', 'total_amount', 'expiration', 'emission_date', 'concept', 'reference'];

	protected $appends = ['balance', 'total_amount', 'expiration', 'emission_date', 'concept', 'reference'];

	/*public function getMovIdAttribute(){
		return $this->MovID;
	}*/

	public function getBalanceAttribute(){
		return $this->Saldo;
	}

	public function getTotalAmountAttribute(){
		return $this->ImporteTotal;
	}

	public function getExpirationAttribute(){
		return $this->Vencimiento->__toString();
	}

	public function getEmissionDateAttribute(){
		return $this->FechaEmision->__toString();
	}

	public function getConceptAttribute(){
		return $this->Concepto;
	}

	public function getReferenceAttribute(){
		return $this->Referencia;
	}

	public function getTableName(){
		return $this->table;
	}
}
