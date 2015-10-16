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


	const TIPO_CAJA = 'Caja';
	const TIPO_BANCO = 'Banco';

	/**
     * Obtiene el modelo de la moneda asociada a la cuenta de dinero.
     */
    public function mon()
    {
        return $this->hasOne('App\Mon','Moneda','Moneda')->select(['TipoCambio']);
    }

	public static function getDestinyAccountList(){

		$destinyAccountList = [];

		$destinyAccounts = self::where(function($query){
			$query->where('Tipo', 'Banco')
					->orwhere('Tipo', 'Caja');
			})->where('Estatus','ALTA')->get(['CtaDinero']);

		foreach ($destinyAccounts as $destinyAccount) {
			$destinyAccountList[] = $destinyAccount;
			
		}
		//dd($destinyAccounts);
		return json_encode($destinyAccountList);
	}


}
