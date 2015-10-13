<?php namespace App\CorteCaja;

use Illuminate\Database\Eloquent\Model;

class DineroSaldo extends Model {

	//protected $primaryKey = ''; Empresa, Moneda, CtaDinero
	
		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'DineroSaldo';

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
		'Empresa',
		'Moneda',
		'CtaDinero',
		'Saldo'
	];

	const COLUMN_NAME_SALDO = 'Saldo';


	public static function getDineroSaldo($company, $currency, $account){
		
		return self::where('Empresa',$company)
					->where('Moneda', $currency)
					->where('CtaDinero',  $account);
	}
}
