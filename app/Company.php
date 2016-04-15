<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Empresa';

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
	protected $visible = ['id','offices','name'];

	protected $with = ['offices'];

	protected $appends = ['id','name'];

	public function getIdAttribute(){
		return $this->Empresa;
	}

	public function getNameAttribute(){
		return $this->Nombre;
	}

	public function offices(){
		return $this->hasMany('App\Office','Empresa','Empresa')->select(['Sucursal','Nombre','Empresa']);
	}

}
