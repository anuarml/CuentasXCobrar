<?php namespace App\CorteCaja;

use Illuminate\Database\Eloquent\Model;

class Dinero extends Model {

	protected $primaryKey = 'ID';
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Dinero';

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
	    'Saldo' => 'float',
	];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = [
		'ID',
		'Empresa',
		'Mov',
		'MovID',
		'FechaEmision',
		'UltimoCambio',
		'Concepto',
		'Moneda',
		'TipoCambio',
		'Referencia',
		'Usuario',
		'Estatus',
		'Directo',
		'CtaDinero',
		'CtaDineroDestino',
		'Desglose',
		'Importe',
		'FormaPago',
		'Sucursal',
		'FechaRegistro'
	];

}
