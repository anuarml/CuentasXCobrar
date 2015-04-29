<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cte';

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
	protected $visible = ['client','name', 'RFC', 'agent', 'collector', 'def_currency'];

	protected $appends = ['client','name', 'RFC', 'agent', 'collector', 'def_currency'];


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
		return $this->defMoneda;
	}
}