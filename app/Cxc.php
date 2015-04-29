<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cxc extends Model {

	public $timestamps = false;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Cxc';

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
	protected $hidden = [];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['details','ID','office_id', 'origin_office_id', 'client_id', 'client_send_to', 'company', 'Mov', 'mov_id','emission_date', 'amount',
							'taxes', 'currency', 'change_type', 'client_currency', 'client_change_type', 'user', 'status', 'CtaDinero', 'cashier',
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown', 'charge_type1',
							'charge_type2', 'charge_type3', 'charge_type4', 'charge_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'tho_web_assigned', 'balance', 'name'];

	protected $appends = ['office_id', 'origin_office_id', 'client_id', 'client_send_to', 'company', 'emission_date', 'amount',
							'taxes', 'currency', 'change_type', 'client_currency', 'client_change_type', 'user', 'status', 'cashier',
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown', 'payment_type1',
							'payment_type2', 'payment_type3', 'payment_type4', 'payment_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'tho_web_assigned'];

	public function getOfficeIdAttribute(){
		return $this->Sucursal;
	}

	public function getOriginOfficeIdAttribute(){
		return $this->SucursalOrigen;
	}



	public function getClientIdAttribute(){
		return $this->Cliente;
	}

	public function setClientIdAttribute($clientID){
		return $this->Cliente = $clientID;
	}



	public function getClientSendToAttribute(){
		return $this->ClienteEnviarA;
	}

	public function getCompanyAttribute(){
		return $this->Empresa;
	}

	public function getMovIdAttribute(){
		return $this->MovID;
	}

	public function getEmissionDateAttribute(){
		return $this->FechaEmision;
	}

	public function getAmountAttribute(){
		return $this->Importe;
	}

	public function getTaxesAttribute(){
		return $this->Impuestos;
	}

	public function getCurrencyAttribute(){
		return $this->Moneda;
	}

	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}

	public function getClientCurrencyAttribute(){
		return $this->ClienteMoneda;
	}

	public function getClientChangeTypeAttribute(){
		return $this->ClienteTipoCambio;
	}

	public function getUserAttribute(){
		return $this->Usuario;
	}

	public function getStatusAttribute(){
		return $this->Estatus;
	}

	public function getCashierAttribute(){
		return $this->Cajero;
	}

	public function getOriginTypeAttribute(){
		return $this->OrigenTipo;
	}

	public function getOriginAttribute(){
		return $this->Origen;
	}

	public function getManualApplyAttribute(){
		return $this->AplicaManual;
	}

	public function getReferenceAttribute(){
		return $this->Referencia;
	}

	public function getConceptAttribute(){
		return $this->Concepto;
	}

	public function getObservationsAttribute(){
		return $this->Observaciones;
	}

	public function getWithBreakdownAttribute(){
		return $this->ConDesglose;
	}

	public function getChargeType1Attribute(){
		return $this->FormaCobro1;
	}

	public function getChargeType2Attribute(){
		return $this->FormaCobro2;
	}

	public function getChargeType3Attribute(){
		return $this->FormaCobro3;
	}

	public function getChargeType4Attribute(){
		return $this->FormaCobro4;
	}

	public function getChargeType5Attribute(){
		return $this->FormaCobro5;
	}

	public function getAmount1Attribute(){
		return $this->Importe1;
	}

	public function getAmount2Attribute(){
		return $this->Importe2;
	}

	public function getAmount3Attribute(){
		return $this->Importe3;
	}

	public function getAmount4Attribute(){
		return $this->Importe4;
	}

	public function getAmount5Attribute(){
		return $this->Importe5;
	}

	public function getReference1Attribute(){
		return $this->Referencia1;
	}

	public function getReference2Attribute(){
		return $this->Referencia2;
	}

	public function getReference3Attribute(){
		return $this->Referencia3;
	}

	public function getReference4Attribute(){
		return $this->Referencia4;
	}

	public function getReference5Attribute(){
		return $this->Referencia5;
	}

	public function getChangeAttribute(){
		return $this->Cambio;
	}

	public function getProBalanceAttribute(){
		return $this->DelEfectivo;
	}

	public function getBalanceAttribute(){
		return $this->Saldo;
	}

	public function getNameAttribute(){
		return $this->Nombre;
	}

	public function getThoWebAssignedAttribute(){
		return $this->ThoAsignadoWeb;
	}

	

	public function details(){
		return $this->hasMany('App\CxcD','ID','ID');
	}

}
