<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipmentMov extends Model {


		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'EmbarqueMov';

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
	protected $visible = ['Mov', 'MovID','total', 'client','charged'];

	protected $appends = ['total', 'client'];

	public function getTotalAttribute(){
		return $this->Importe + $this->Impuestos;
	}

	public function getClientAttribute(){
		return $this->Cliente;
	}

	public static function getAsignedDocuments($chargeOrderID){

		$assignedDocuments = self::whereIn('AsignadoID',$chargeOrderID)->get(['Importe','Impuestos','Cliente','Mov','MovID']);

		return $assignedDocuments;
	}
}
