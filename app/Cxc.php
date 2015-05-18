<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cxc extends Model {

	public $timestamps = false;

	protected $primaryKey = 'ID';

	//protected $dates = ['FechaEmision'];

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
	protected $fillable = ['last_change','details','office_id', 'origin_office_id', 'client_id', 'client_send_to', 'company', 'Mov', 'MovID','emission_date','emission_date_str', 'amount',
							'taxes', 'currency', 'change_type', 'client_currency', 'client_change_type', 'user', 'status', 'CtaDinero', 'cashier',
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown', 'charge_type1',
							'charge_type2', 'charge_type3', 'charge_type4', 'charge_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'tho_web_assigned', 'balance'];

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
	protected $visible = ['last_change','client','details','ID','office_id', 'origin_office_id', 'client_id', 'client_send_to', 'company', 'Mov', 'MovID','emission_date','emission_date_str', 'amount',
							'taxes', 'currency', 'change_type', 'client_currency', 'client_change_type', 'user', 'status', 'CtaDinero', 'cashier',
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown', 'charge_type1',
							'charge_type2', 'charge_type3', 'charge_type4', 'charge_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'balance', 'tho_web_assigned' ];

	protected $appends = ['last_change','office_id', 'origin_office_id', 'client_id', 'client_send_to', 'company', 'emission_date', 'emission_date_str', 'amount',
							'taxes', 'currency', 'change_type', 'client_currency', 'client_change_type', 'user', 'status', 'cashier',
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown','charge_type1',
							'charge_type2', 'charge_type3', 'charge_type4', 'charge_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'balance', 'tho_web_assigned' ];

	
	public function getOfficeIdAttribute(){
		return $this->Sucursal;
	}
	public function setOfficeIdAttribute($officeID){
		return $this->Sucursal = $officeID;
	}


	public function getOriginOfficeIdAttribute(){
		return $this->SucursalOrigen;
	}
	public function setOriginOfficeIdAttribute($originOfficeID){
		return $this->SucursalOrigen = $originOfficeID;
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
	public function setClientSendToAttribute($clientSendTo){
		return $this->ClienteEnviarA = $clientSendTo;
	}


	public function getCompanyAttribute(){
		return $this->Empresa;
	}
	public function setCompanyAttribute($company){
		return $this->Empresa = $company;
	}

	public function getEmissionDateAttribute(){
		return (new \Carbon\Carbon($this->FechaEmision))->__toString();
	}

	public function getEmissionDateStrAttribute(){
		return (new \Carbon\Carbon($this->FechaEmision))->toDateString();
	}

	public function setEmissionDateAttribute($emissionDate){
		return $this->FechaEmision = $emissionDate;
	}

	

	public function getAmountAttribute(){
		return $this->Importe;
	}
	public function setAmountAttribute($amount){
		return $this->Importe = $amount;
	}


	public function getTaxesAttribute(){
		return $this->Impuestos;
	}
	public function setTaxesAttribute($taxes){
		return $this->Impuestos = $taxes;
	}


	public function getCurrencyAttribute(){
		return $this->Moneda;
	}
	public function setCurrencyAttribute($currency){
		return $this->Moneda = $currency;
	}


	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}
	public function setChangeTypeAttribute($changeType){
		return $this->TipoCambio = $changeType;
	}


	public function getClientCurrencyAttribute(){
		return $this->ClienteMoneda;
	}
	public function setClientCurrencyAttribute($clientCurrency){
		return $this->ClienteMoneda = $clientCurrency;
	}


	public function getClientChangeTypeAttribute(){
		return $this->ClienteTipoCambio;
	}
	public function setClientChangeTypeAttribute($clientChangeType){
		return $this->ClienteTipoCambio = $clientChangeType;
	}


	public function getUserAttribute(){
		return $this->Usuario;
	}
	public function setUserAttribute($user){
		return $this->Usuario = $user;
	}


	public function getStatusAttribute(){
		return $this->Estatus;
	}
	public function setStatusAttribute($status){
		return $this->Estatus = $status;
	}


	public function getCashierAttribute(){
		return $this->Cajero;
	}
	public function setCashierAttribute($cashier){
		return $this->Cajero = $cashier;
	}


	public function getOriginTypeAttribute(){
		return $this->OrigenTipo;
	}
	public function setOriginTypeAttribute($originType){
		return $this->OrigenTipo = $originType;
	}


	public function getOriginAttribute(){
		return $this->Origen;
	}
	public function setOriginAttribute($origin){
		return $this->Origen = $origin;
	}


	public function getManualApplyAttribute(){
		return $this->AplicaManual;
	}
	public function setManualApplyAttribute($manualApply){
		return $this->AplicaManual = $manualApply;
	}


	public function getReferenceAttribute(){
		return $this->Referencia;
	}
	public function setReferenceAttribute($reference){
		return $this->Referencia = $reference;
	}


	public function getConceptAttribute(){
		return $this->Concepto;
	}
	public function setConceptAttribute($concept){
		return $this->Concepto = $concept;
	}


	public function getObservationsAttribute(){
		return $this->Observaciones;
	}
	public function setObservationsAttribute($observations){
		return $this->Observaciones = $observations;
	}


	public function getWithBreakdownAttribute(){
		return $this->ConDesglose;
	}
	public function setWithBreakdownAttribute($withBreakdown){
		return $this->ConDesglose = $withBreakdown;
	}


	public function getChargeType1Attribute(){
		return $this->FormaCobro1;
	}
	public function setChargeType1Attribute($chargeType1){
		return $this->FormaCobro1 = $chargeType1;
	}


	public function getChargeType2Attribute(){
		return $this->FormaCobro2;
	}
	public function setChargeType2Attribute($chargeType2){
		return $this->FormaCobro2 = $chargeType2;
	}


	public function getChargeType3Attribute(){
		return $this->FormaCobro3;
	}
	public function setChargeType3Attribute($chargeType3){
		return $this->FormaCobro3 = $chargeType3;
	}


	public function getChargeType4Attribute(){
		return $this->FormaCobro4;
	}
	public function setChargeType4Attribute($chargeType4){
		return $this->FormaCobro4 = $chargeType4;
	}


	public function getChargeType5Attribute(){
		return $this->FormaCobro5;
	}
	public function setChargeType5Attribute($chargeType5){
		return $this->FormaCobro5 = $chargeType5;
	}


	public function getAmount1Attribute(){
		return $this->Importe1;
	}
	public function setAmount1Attribute($amount1){
		return $this->Importe1 = $amount1;
	}


	public function getAmount2Attribute(){
		return $this->Importe2;
	}
	public function setAmount2Attribute($amount2){
		return $this->Importe2 = $amount2;
	}


	public function getAmount3Attribute(){
		return $this->Importe3;
	}
	public function setAmount3Attribute($amount3){
		return $this->Importe3 = $amount3;
	}


	public function getAmount4Attribute(){
		return $this->Importe4;
	}
	public function setAmount4Attribute($amount4){
		return $this->Importe4 = $amount4;
	}


	public function getAmount5Attribute(){
		return $this->Importe5;
	}
	public function setAmount5Attribute($amount5){
		return $this->Importe5 = $amount5;
	}


	public function getReference1Attribute(){
		return $this->Referencia1;
	}
	public function setReference1Attribute($reference){
		return $this->Referencia1 = $reference;
	}


	public function getReference2Attribute(){
		return $this->Referencia2;
	}
	public function setReference2Attribute($reference){
		return $this->Referencia2 = $reference;
	}


	public function getReference3Attribute(){
		return $this->Referencia3;
	}
	public function setReference3Attribute($reference){
		return $this->Referencia3 = $reference;
	}


	public function getReference4Attribute(){
		return $this->Referencia4;
	}
	public function setReference4Attribute($reference){
		return $this->Referencia4 = $reference;
	}


	public function getReference5Attribute(){
		return $this->Referencia5;
	}
	public function setReference5Attribute($reference){
		return $this->Referencia5 = $reference;
	}


	public function getChangeAttribute(){
		return $this->Cambio;
	}
	public function setChangeAttribute($change){
		return $this->Cambio = $change;
	}


	public function getProBalanceAttribute(){
		return $this->DelEfectivo;
	}
	public function setProBalanceAttribute($proBalance){
		return $this->DelEfectivo = $proBalance;
	}


	public function getBalanceAttribute(){
		return $this->Saldo;
	}
	public function setBalanceAttribute($balance){
		return $this->Saldo = $balance;
	}


	public function getThoWebAssignedAttribute(){
		return $this->ThoAsignadoWeb;
	}
	public function setThoWebAssignedAttribute($thoWebAssigned){
		return $this->ThoAsignadoWeb = $thoWebAssigned;
	}

	public function getLastChangeAttribute(){
		return $this->UltimoCambio;
	}

	public function setLastChangeAttribute($lastChange){
		return $this->UltimoCambio = $lastChange;
	}
	

	/*
	 * Relaciones con otros modelos.
	 */

	public function details(){
		return $this->hasMany('App\CxcD','ID','ID');
	}

	public function client(){
		return $this->belongsTo('App\Client', 'Cliente', 'Cliente');
	}


	/*
	 *	MovID en edición. Se guarda en la session.
	 */

	public static function getSessionMovID(){

		$sessionMovID = null;

		if(\Session::has('movID')){
			$sessionMovID = \Session::get('movID');
		}

		return $sessionMovID;
	}

	public static function setSessionMovID($movID){

		\Session::put('movID',$movID);
	}

	public static function hasSessionMovID(){

		return \Session::has('movID');
	}

	public static function removeSessionMovID(){

		return \Session::forget('movID');
	}
}
