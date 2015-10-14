<?php namespace App\CorteCaja;

use Illuminate\Database\Eloquent\Model;

class CtaDinero extends Model {

	protected $primaryKey = 'CtaDinero';
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CtaDinero';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = [
		'CtaDinero',
		'Descripcion',
		'Tipo',
		'Moneda',
		'Empresa',
		'Estatus',
	];

}