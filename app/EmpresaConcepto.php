<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaConcepto extends Model {

	//protected $primaryKey = 'CtaDinero'; Empresa, Modulo, Mov

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'EmpresaConcepto';

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['Concepto','Requerido'];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
        'Requerido' => 'boolean',
	];

	public static function findByPk($empresa, $modulo, $mov, array $columns = array('*')){

		return self::where('Empresa',$empresa)
					->where('Modulo',$modulo)
					->where('Mov',$mov)
					->whereNotNull('Empresa')
					->whereNotNull('Modulo')
					->whereNotNull('Mov')
					->select($columns)
					->first();
	}
}
