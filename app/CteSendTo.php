<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CteSendTo extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CteEnviarA';

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
	protected $visible = ['ID','name', 'address'];

	protected $appends = ['ID','name', 'address'];

	public function getNameAttribute(){
		return $this->Nombre;
	}

	public function getAddressAttribute(){
		return $this->Direccion;
	}

}
