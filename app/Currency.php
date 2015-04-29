<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {

	public $timestamps = false;

	protected $primaryKey = 'Moneda';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Mon';

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
	protected $visible = ['currency','changeType'];

	protected $appends = ['currency','changeType'];

	public function getCurrencyAttribute(){
		return $this->Moneda;
	}
	public function setCurrencyAttribute($currency){
		return $this->Moneda = $currency;
	}

	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}
	public function setChangeTypeAttribute($changeType){
		return $this->TipoCambio = $changeType;
	}

}
