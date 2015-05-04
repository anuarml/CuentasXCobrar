<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcD extends Model {

	public $timestamps = false;
	protected $primaryKey = 'Renglon';
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
	protected $fillable = ['office','row','apply', 'apply_id', 'amount', 'p_p_discount'];

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
	
	protected $appends = ['office','row','apply', 'apply_id', 'amount', 'p_p_discount'];

	public function getOfficeAttribute(){
		return $this->Sucursal;
	}
	public function setOfficeAttribute($office){
		return $this->Sucursal = $office;
	}


	public function getRowAttribute(){
		return $this->Renglon;
	}
	public function setRowAttribute($row){
		return $this->Renglon = $row;
	}


	public function getApplyAttribute(){
		return $this->Aplica;
	}
	public function setApplyAttribute($apply){
		return $this->Aplica = $apply;
	}


	public function getApplyIdAttribute(){
		return $this->AplicaID;
	}
	public function setApplyIdAttribute($applyID){
		return $this->AplicaID = $applyID;
	}


	public function getAmountAttribute(){
		return $this->Importe;
	}
	public function setAmountAttribute($amount){
		return $this->Importe = $amount;
	}


	public function getPPDiscountAttribute(){
		return $this->DescuentoRecargos;
	}
	public function setPPDiscountAttribute($ppDiscount){
		return $this->DescuentoRecargos = $ppDiscount;
	}
}

