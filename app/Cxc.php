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
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown','charge_type', 'charge_type1',
							'charge_type2', 'charge_type3', 'charge_type4', 'charge_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'balance', 'tho_web_assigned','expiration','condition','pp_suggest','total_amount','factor','shipment_state'];

	protected $appends = ['last_change','office_id', 'origin_office_id', 'client_id', 'client_send_to', 'company', 'emission_date', 'emission_date_str', 'amount',
							'taxes', 'currency', 'change_type', 'client_currency', 'client_change_type', 'user', 'status', 'cashier',
							'origin_type', 'origin', 'manual_apply', 'reference', 'concept', 'observations', 'with_breakdown','charge_type','charge_type1',
							'charge_type2', 'charge_type3', 'charge_type4', 'charge_type5', 'amount1', 'amount2', 'amount3', 'amount4', 
							'amount5', 'reference1', 'reference2', 'reference3', 'reference4', 'reference5', 'change', 'pro_balance', 'balance', 'tho_web_assigned','expiration','condition','total_amount','factor','shipment_state'];


	public static function getChargeName(){
		return env('CXC_COBRO', 'Cobro');
	}

	public static function getAdvanceName(){
		return env('CXC_ANTICIPO', 'Anticipo');
	}
	
	public function getOfficeIdAttribute(){
		return $this->Sucursal;
	}
	public function setOfficeIdAttribute($officeID){
		if($officeID == ''){
			$officeID = null;
		}
		$this->Sucursal = $officeID;
	}


	public function getOriginOfficeIdAttribute(){
		return $this->SucursalOrigen;
	}
	public function setOriginOfficeIdAttribute($originOfficeID){
		if($originOfficeID == ''){
			$originOfficeID = null;
		}
		$this->SucursalOrigen = $originOfficeID;
	}


	public function getClientIdAttribute(){
		return $this->Cliente;
	}
	public function setClientIdAttribute($clientID){
		if($clientID == ''){
			$clientID = null;
		}
		$this->Cliente = $clientID;
	}


	public function getClientSendToAttribute(){
		return $this->ClienteEnviarA;
	}
	public function setClientSendToAttribute($clientSendTo){
		if($clientSendTo == ''){
			$clientSendTo = null;
		}
		$this->ClienteEnviarA = $clientSendTo;
	}


	public function getCompanyAttribute(){
		return $this->Empresa;
	}
	public function setCompanyAttribute($company){
		if($company == ''){
			$company = null;
		}
		$this->Empresa = $company;
	}

	public function getEmissionDateAttribute(){
		//return (new \Carbon\Carbon($this->FechaEmision))->__toString();
		return (new \Carbon\Carbon($this->FechaEmision))->formatLocalized('%d/%b/%Y');
	}

	public function getEmissionDateStrAttribute(){
		return (new \Carbon\Carbon($this->FechaEmision))->toDateString();
	}

	public function setEmissionDateAttribute($emissionDate){
		if($emissionDate == ''){
			$emissionDate = null;
		}
		$this->FechaEmision = $emissionDate;
	}

	public function setEmissionDateStrAttribute($emissionDate){
		if($emissionDate == ''){
			$this->FechaEmision = null;
		}
		else {
			$this->FechaEmision = (new \Carbon\Carbon($emissionDate))->format('d/m/Y');
		}
	}

	

	public function getAmountAttribute(){
		return $this->Importe;
	}
	public function setAmountAttribute($amount){
		if($amount == ''){
			$amount = null;
		}
		$this->Importe = $amount;
	}


	public function getTaxesAttribute(){
		return $this->Impuestos;
	}
	public function setTaxesAttribute($taxes){
		if($taxes == ''){
			$taxes = null;
		}
		$this->Impuestos = $taxes;
	}


	public function getCurrencyAttribute(){
		return $this->Moneda;
	}
	public function setCurrencyAttribute($currency){
		if($currency == ''){
			$currency = null;
		}
		$this->Moneda = $currency;
	}


	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}
	public function setChangeTypeAttribute($changeType){
		if($changeType == ''){
			$changeType = null;
		}
		$this->TipoCambio = $changeType;
	}


	public function getClientCurrencyAttribute(){
		return $this->ClienteMoneda;
	}
	public function setClientCurrencyAttribute($clientCurrency){
		if($clientCurrency == ''){
			$clientCurrency = null;
		}
		$this->ClienteMoneda = $clientCurrency;
	}


	public function getClientChangeTypeAttribute(){
		return $this->ClienteTipoCambio;
	}
	public function setClientChangeTypeAttribute($clientChangeType){
		if($clientChangeType == ''){
			$clientChangeType = null;
		}
		$this->ClienteTipoCambio = $clientChangeType;
	}


	public function getUserAttribute(){
		return $this->Usuario;
	}
	public function setUserAttribute($user){
		if($user == ''){
			$user = null;
		}
		$this->Usuario = $user;
	}


	public function getStatusAttribute(){
		return $this->Estatus;
	}
	public function setStatusAttribute($status){
		if($status == ''){
			$status = null;
		}
		$this->Estatus = $status;
	}


	public function getCashierAttribute(){
		return $this->Cajero;
	}
	public function setCashierAttribute($cashier){
		if($cashier == ''){
			$cashier = null;
		}
		$this->Cajero = $cashier;
	}


	public function getOriginTypeAttribute(){
		return $this->OrigenTipo;
	}
	public function setOriginTypeAttribute($originType){
		if($originType == ''){
			$originType = null;
		}
		$this->OrigenTipo = $originType;
	}


	public function getOriginAttribute(){
		return $this->Origen;
	}
	public function setOriginAttribute($origin){
		if($origin == ''){
			$origin = null;
		}
		$this->Origen = $origin;
	}


	public function getManualApplyAttribute(){
		return $this->AplicaManual;
	}
	public function setManualApplyAttribute($manualApply){
		if($manualApply == ''){
			$manualApply = null;
		}
		$this->AplicaManual = $manualApply;
	}


	public function getReferenceAttribute(){
		return $this->Referencia;
	}
	public function setReferenceAttribute($reference){
		if($reference == ''){
			$reference = null;
		}
		$this->Referencia = $reference;
	}


	public function getConceptAttribute(){
		return $this->Concepto;
	}
	public function setConceptAttribute($concept){
		if($concept == ''){
			$concept = null;
		}
		$this->Concepto = $concept;
	}


	public function getObservationsAttribute(){
		return $this->Observaciones;
	}
	public function setObservationsAttribute($observations){
		if($observations == ''){
			$observations = null;
		}
		$this->Observaciones = $observations;
	}


	public function getWithBreakdownAttribute(){
		return $this->ConDesglose;
	}
	public function setWithBreakdownAttribute($withBreakdown){
		if($withBreakdown == ''){
			$withBreakdown = null;
		}
		$this->ConDesglose = $withBreakdown;
	}


	public function getChargeTypeAttribute(){
		return $this->FormaCobro;
	}
	public function setChargeTypeAttribute($chargeType){
		if($chargeType == ''){
			$chargeType = null;
		}
		$this->FormaCobro = $chargeType;
	}


	public function getChargeType1Attribute(){
		return $this->FormaCobro1;
	}
	public function setChargeType1Attribute($chargeType1){
		if($chargeType1 == ''){
			$chargeType1 = null;
		}
		$this->FormaCobro1 = $chargeType1;
	}


	public function getChargeType2Attribute(){
		return $this->FormaCobro2;
	}
	public function setChargeType2Attribute($chargeType2){
		if($chargeType2 == ''){
			$chargeType2 = null;
		}
		$this->FormaCobro2 = $chargeType2;
	}


	public function getChargeType3Attribute(){
		return $this->FormaCobro3;
	}
	public function setChargeType3Attribute($chargeType3){
		if($chargeType3 == ''){
			$chargeType3 = null;
		}
		$this->FormaCobro3 = $chargeType3;
	}


	public function getChargeType4Attribute(){
		return $this->FormaCobro4;
	}
	public function setChargeType4Attribute($chargeType4){
		if($chargeType4 == ''){
			$chargeType4 = null;
		}
		$this->FormaCobro4 = $chargeType4;
	}


	public function getChargeType5Attribute(){
		return $this->FormaCobro5;
	}
	public function setChargeType5Attribute($chargeType5){
		if($chargeType5 == ''){
			$chargeType5 = null;
		}
		$this->FormaCobro5 = $chargeType5;
	}


	public function getAmount1Attribute(){
		return $this->Importe1;
	}
	public function setAmount1Attribute($amount1){
		if($amount1 == ''){
			$amount1 = null;
		}else{
			$amount1 = str_replace(',','',$amount1);
		}
		$this->Importe1 = $amount1;
	}


	public function getAmount2Attribute(){
		return $this->Importe2;
	}
	public function setAmount2Attribute($amount2){
		if($amount2 == ''){
			$amount2 = null;
		}else{
			$amount2 = str_replace(',','',$amount2);
		}
		$this->Importe2 = $amount2;
	}


	public function getAmount3Attribute(){
		return $this->Importe3;
	}
	public function setAmount3Attribute($amount3){
		if($amount3 == ''){
			$amount3 = null;
		}else{
			$amount3 = str_replace(',','',$amount3);
		}
		$this->Importe3 = $amount3;
	}


	public function getAmount4Attribute(){
		return $this->Importe4;
	}
	public function setAmount4Attribute($amount4){
		if($amount4 == ''){
			$amount4 = null;
		}else{
			$amount4 = str_replace(',','',$amount4);
		}
		$this->Importe4 = $amount4;
	}


	public function getAmount5Attribute(){
		return $this->Importe5;
	}
	public function setAmount5Attribute($amount5){
		if($amount5 == ''){
			$amount5 = null;
		}else{
			$amount5 = str_replace(',','',$amount5);
		}
		$this->Importe5 = $amount5;
	}


	public function getReference1Attribute(){
		return $this->Referencia1;
	}
	public function setReference1Attribute($reference){
		if($reference == ''){
			$reference = null;
		}
		$this->Referencia1 = $reference;
	}


	public function getReference2Attribute(){
		return $this->Referencia2;
	}
	public function setReference2Attribute($reference){
		if($reference == ''){
			$reference = null;
		}
		$this->Referencia2 = $reference;
	}


	public function getReference3Attribute(){
		return $this->Referencia3;
	}
	public function setReference3Attribute($reference){
		if($reference == ''){
			$reference = null;
		}
		$this->Referencia3 = $reference;
	}


	public function getReference4Attribute(){
		return $this->Referencia4;
	}
	public function setReference4Attribute($reference){
		if($reference == ''){
			$reference = null;
		}
		$this->Referencia4 = $reference;
	}


	public function getReference5Attribute(){
		return $this->Referencia5;
	}
	public function setReference5Attribute($reference){
		if($reference == ''){
			$reference = null;
		}
		$this->Referencia5 = $reference;
	}


	public function getChangeAttribute(){
		return $this->Cambio;
	}
	public function setChangeAttribute($change){
		if($change == ''){
			$change = null;
		}else{
			$change = str_replace(',','',$change);
		}
		$this->Cambio = $change;
	}


	public function getProBalanceAttribute(){
		return $this->DelEfectivo;
	}
	public function setProBalanceAttribute($proBalance){
		if($proBalance == ''){
			$proBalance = null;
		}else{
			$proBalance = str_replace(',','',$proBalance);
		}
		$this->DelEfectivo = $proBalance;
	}


	public function getBalanceAttribute(){
		return $this->Saldo;
	}
	public function setBalanceAttribute($balance){
		if($balance == ''){
			$balance = null;
		}
		$this->Saldo = $balance;
	}


	public function getThoWebAssignedAttribute(){
		return $this->ThoAsignadoWeb;
	}
	public function setThoWebAssignedAttribute($thoWebAssigned){
		if($thoWebAssigned == ''){
			$thoWebAssigned = null;
		}
		$this->ThoAsignadoWeb = $thoWebAssigned;
	}

	public function getLastChangeAttribute(){
		return $this->UltimoCambio;
	}

	public function setLastChangeAttribute($lastChange){
		if($lastChange == ''){
			$lastChange = null;
		}
		$this->UltimoCambio = $lastChange;
	}

	public function getConditionAttribute(){
		return $this->Condicion;
	}

	public function setConditionAttribute($condition){
		if($condition == ''){
			$condition = null;
		}
		$this->Condicion = $condition;
	}

	public function getExpirationAttribute(){
		return $this->Vencimiento;
	}

	public function setExpirationAttribute($expiration){
		if($expiration == ''){
			$this->Vencimiento = null;
		}
		else {
			$this->Vencimiento = (new \Carbon\Carbon($expiration))->format('d/m/Y');
		}
	}

	public function getTotalAmountAttribute(){
		$totalAmount = 0;
		$totalAmount += $this->Impuestos + $this->Importe;
		return $totalAmount;
	}

	public function getFactorAttribute(){

		$factor = 1;

		$movType = MovType::where('Modulo','CXC')->where('Mov',$this->Mov)->first();

		if($movType){
			$factor = $movType->Factor;
		}

		return $factor;
	}

	public function getShipmentStateAttribute(){
		return $this->EmbarqueEstado;
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

	public static function affect($movID, $username, $action){

		$module = 'CXC';
		//$action = 'AFECTAR' || 'CANCELAR'
		$message = '';
		$reference = '';
		
		if( !$username || !$movID || !$action){
			return null;
		}

		$stmt = \DB::getPdo()->prepare('EXECUTE spAfectar ?, ?, ?, NULL, NULL, ?, 1, 1, ?, ?');

		$stmt->bindParam(1, $module);
		$stmt->bindParam(2, $movID);
		$stmt->bindParam(3, $action);
		$stmt->bindParam(4, $username);
		$stmt->bindParam(5, $message, \PDO::PARAM_STR, 40);
		$stmt->bindParam(6, $reference, \PDO::PARAM_STR, 255);

		if( !$stmt->execute() ){
			return null;
		}

		return array('message' => $message, 'reference' => $reference);
	}

	public function getCharges(){

		$charge1 = array('amount' =>  $this->amount1, 'payment_type' => $this->charge_type1, 'reference' => $this->reference1);
		$charge2 = array('amount' =>  $this->amount2, 'payment_type' => $this->charge_type2, 'reference' => $this->reference2);
		$charge3 = array('amount' =>  $this->amount3, 'payment_type' => $this->charge_type3, 'reference' => $this->reference3);
		$charge4 = array('amount' =>  $this->amount4, 'payment_type' => $this->charge_type4, 'reference' => $this->reference4);
		$charge5 = array('amount' =>  $this->amount5, 'payment_type' => $this->charge_type5, 'reference' => $this->reference5);

		$charges = array($charge1,$charge2,$charge3,$charge4,$charge5);


		return $charges;
	}

	public function getChangeAllowed(){
		$charges = $this->getCharges();
		$paymentTypeListChangeAllowed = json_decode(PaymentType::getPaymentTypeChangeAllowed(),true);
		$totalChangeAllowedAmount = 0;
		$paymentTypeList = json_decode(PaymentType::getPaymentTypeList());
		//dd($charges);
		for ($i=0; $i < count($charges); $i++) { 
			if($charges[$i] && $charges[$i]['payment_type']){
				//dd($paymentTypeListChangeAllowed);
				//dd($charges[$i]['payment_type']);
				//dd((bool)$paymentTypeListChangeAllowed[$charges[$i]['payment_type']]);

				//$key = array_search($charges[$i]['payment_type'], array_column($paymentTypeList,'payment_type'));
				//echo($key);

				foreach ($paymentTypeList as $paymentType) {
					
					if($charges[$i]['payment_type'] == $paymentType->payment_type){
						if((bool)$paymentTypeListChangeAllowed[$charges[$i]['payment_type']]){
							$totalChangeAllowedAmount += $charges[$i]['amount'];

						}
					}

				}
				/*if((bool)$paymentTypeListChangeAllowed[$charges[$i]['payment_type']]){
					$totalChangeAllowedAmount += $charges[$i]['amount'];
				}*/
			}
		}
		//dd($totalChangeAllowedAmount);
		return $totalChangeAllowedAmount;
	}

	public static function getChargedDocuments($chargeOrder){

		$chargedDocuments = collect([]);

		$chargeMovs = self::where(function ($query) {
						$query->where('Mov', self::getChargeName())
							->orWhere('Mov', self::getAdvanceName());
					})
					->where('Estatus','CONCLUIDO')
					->whereIn('ThoAsignadoWeb',$chargeOrder)
					->get();

		//dd($chargeMovs);

		foreach ($chargeMovs as $chargeMov) {

			foreach ($chargeMov->details as $detail) {
				$chargedDocuments->push($detail);
			}
		}

		return $chargedDocuments;
	}

	public function clearCharges(){
		$this->amount1 = null;
		$this->charge_type1 = null;
		$this->reference1 = null;

		$this->amount2 = null;
		$this->charge_type2 = null;
		$this->reference2 = null;

		$this->amount3 = null;
		$this->charge_type3 = null;
		$this->reference3 = null;

		$this->amount4 = null;
		$this->charge_type4 = null;
		$this->reference4 = null;

		$this->amount5 = null;
		$this->charge_type5 = null;
		$this->reference5 = null;
	}
}
