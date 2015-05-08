<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	protected $primaryKey = 'Cliente';
	
		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Cte';

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
	protected $visible = ['balance','id','name', 'RFC', 'agent', 'collector', 'def_currency'];

	protected $appends = ['id','name', 'agent', 'collector', 'def_currency'];


	public function getIdAttribute(){
		return $this->Cliente;
	}

	public function getNameAttribute(){
		return $this->Nombre;
	}

	public function getAgentAttribute(){
		return $this->Agente;
	}

	public function getCollectorAttribute(){
		return $this->Cobrador;
	}

	public function getDefCurrencyAttribute(){
		return $this->DefMoneda;
	}

	/*
	 * Relations with other models.
	 */

	public function balance(){

		return $this->hasMany('App\CxcBalance','Cliente','Cliente');
	}

}
