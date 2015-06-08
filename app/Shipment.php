<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model {

	protected $primaryKey = 'ID';
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Embarque';

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
	/*protected $visible = ['mov', 'mov_id'];

	protected $appends = ['mov', 'mov_id'];

	public function getMovAttribute(){
		return $this->Mov;
	}

	public function getMovIdAttribute(){
		return $this->MovID;
	}*/

	public static function getChargeOrderID(){

		$chargeOrderID = null;
		$user = \Auth::user();

		if (!$user) {
			return $chargeOrder;
		}

		$company = $user->getSelectedCompany();
		$agent = $user->agent;

		$chargeOrder = self::where('Mov','Orden Cobro')->where('Estatus','PENDIENTE')->where('Empresa',$company)->where('Agente',$agent)->first(['ID']);

		if($chargeOrder){
			$chargeOrderID = $chargeOrder->ID;
		}

		return $chargeOrderID;
	}
}
