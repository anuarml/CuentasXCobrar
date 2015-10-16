<?php namespace App\CorteCaja;

use Illuminate\Database\Eloquent\Model;

class ListaD extends Model {

	protected $primaryKey = 'ListaD';
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ListaD';

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
		'Rama',
		'Lista',
		'Visible',
		'Cuenta',
		'Grupo',
		'Subgrupo',
		'Signo'
	];


	public static function getDestinyAccountList(){

		$destinyAccountList = [];

		$destinyAccounts = self::where('Rama', 'DIN')->where('Lista','TM.0.Matriz')->get(['Cuenta']);

		foreach ($destinyAccounts as $destinyAccount) {
			$destinyAccountList[] = $destinyAccount;
			
		}
		//dd($destinyAccounts);
		return json_encode($destinyAccountList);
	}


}
