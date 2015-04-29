<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcD extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcD';

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
	protected $hidden = [];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['office','ID','row','apply', 'apply_id', 'amount', 'p_p_discount'];
	
	protected $appends = ['office','ID','row','apply', 'apply_id', 'amount', 'p_p_discount'];

	public function getOfficeAttribute(){
		return $this->Sucursal;
	}

	public function getRowAttribute(){
		return $this->Renglon;
	}

	public function getApplyAttribute(){
		return $this->Aplica;
	}

	public function getApplyIdAttribute(){
		return $this->AplicaID;
	}

	public function getAmountAttribute(){
		return $this->Importe;
	}

	public function getPPDiscountAttribute(){
		return $this->DescuentoRecargos;
	}
}

