<?php namespace App\Http\Controllers\Cxc;

use App\Cxc;
use App\CxcD;
use App\CxcRef;
use App\Concept;
use App\Client;
use App\CteSendTo;
use App\Currency;
use App\CxcPending;
use App\DBTranslations;
use App\MessageList;
use App\Mon;
use App\MovType;
use App\Office;
use App\PaymentType;
use App\Shipment;
use App\ThoUserAccess;

use App\Http\Controllers\Controller;
use Carbon\Carbon;


class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getNuevo(){

		if(Cxc::hasSessionMovID()){
			$movID = Cxc::getSessionMovID();
			return redirect('cxc/movimiento/mov/'.$movID);
		}


		$mov = new Cxc;

		$clientName = '';
		$clientBalance = '';

		// Se obtiene el usuario autenticado.
		$user = \Auth::user();

		if(\Session::has('selected_client_id')) {

			// Se guarda en el movimiento la ID del cliente seleccionado en la vista buscar cliente.
			$mov->client_id = \Session::get('selected_client_id');

			// Se obtiene el cliente con el id seleccionado.
			$mov->load('client');

			// Si el cliente es válido
			if($client = $mov->client){
				// Se obtiene el saldo del cliente.
				$clientBalance = $client->balance()->where('Empresa', $user->getSelectedCompany())->where('Moneda','Pesos')->first();

			} 
			else {
				$mov->client_id = null;
			}
		}
		$clientBalance = json_encode($clientBalance);

		// Se obtiene el nombre de la oficina seleccionada por el usuario en el login.
		// Se utiliza en la impresión del ticket.
		$officeName = Office::find($user->getSelectedOffice())->name;

		// Se obtienen las opciones de las listas desplegables.
		$movTypeList = MovType::getMovTypeList();
		$currencyList = Mon::getCurrencyList();
		$paymentTypeList = PaymentType::getPaymentTypeList();
		$paymentTypeListChangeAllowed = PaymentType::getPaymentTypeChangeAllowed();
		$totalChangeAllowedAmount = 0;
		$movCharges = json_encode(null);
		
		//return view('cxc.movement.new', compact('clientName'));
		return view('cxc.movement.mov', compact('mov', 'user', 'clientBalance','officeName','movTypeList','currencyList','paymentTypeList','movCharges', 'paymentTypeListChangeAllowed','totalChangeAllowedAmount'));
	}

	public function postNuevo(){
		Cxc::removeSessionMovID();
		return redirect('cxc/movimiento/nuevo');
	}

	public function postGuardar(){

		$movID = Cxc::getSessionMovID();
		$cxc = Cxc::findOrNew($movID);

		if($cxc->status && $cxc->status != 'SINAFECTAR'){
			return redirect()->back()->withInput()->withErrors([
				'Status'=>'Solo puedes guardar movimientos con estatus \'SINAFECTAR\'.',
			]);
		}

		$cxcArray = \Input::except('documentsJson');
		$cxcDArray = json_decode(\Input::get('documentsJson'));

		$user = \Auth::user();

		//CXC Required
		//Company - Empresa
		//Mov
		//Currency - Moneda
		//Client_id - Cliente
		//1 - AplicaManual
		//1 - ConDesglose
		//selectedOffice - SucursalOrigen
		$validator = \Validator::make($cxcArray, [
			'Mov' => 'required',
			'currency' => 'required',
			'client_id' => 'required',
		],
		[
			'Mov.required'=>'Es necesario seleccionar un Movimiento.',
			'currency.required'=>'Es necesario seleccionar una Moneda.',
			'client_id.required'=>'Es necesario seleccionar un Cliente.',
		]);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}

		//$cxc = new Cxc;
		$cxc->fill($cxcArray);
		$cxc->user = $user->username;
		$cxc->company = $user->getSelectedCompany();
		$cxc->office_id = $user->getSelectedOffice();
		$cxc->origin_office_id = $user->getSelectedOffice();
		$cxc->CtaDinero = $user->account;
		$cxc->charge_type = $user->payment_type;
		$cxc->cashier = $user->cashier;
		//$cxc->currency = $user->defCurrency->currency;
		$cxc->manual_apply = true;
		$cxc->with_breakdown = true;
		$cxc->status = 'SINAFECTAR';
		$cxc->last_change = Carbon::now()->format('d/m/Y');
		$cxc->expiration = $cxcArray['emission_date_str'];
		$cxc->condition = 'Contado';

		// Obtiene el ID de la orden de cobro asignada al usuario autenticado.
		$chargeOrders = Shipment::getChargeOrdersID();
		$chargeOrdersLength = count($chargeOrders);
		$chargeOrderID = null;
		if($chargeOrdersLength > 0){
			$chargeOrderID = $chargeOrders[$chargeOrdersLength-1];
		}
		$cxc->tho_web_assigned = $chargeOrderID;

		$changeType = 1;
		$currency = Currency::find($cxc->currency);
		if($currency){
			$changeType = $currency->change_type;
		}

		$cxc->client_change_type = $cxc->change_type = $changeType;
		$cxc->client_currency = $cxc->currency;
		//dd($cxc);
		$cxc->save();

		/*foreach ($cxc->details as $cxcDetail) {
			$cxcDetail->delete();
		}*/
		$cxc->details()->delete();

		$ROW_MULTIPLIER = 2048;
		$rowNum = 1;
		$tableRowID = '';
		$clickedRow = \Input::get('clickedRow');
		foreach ($cxcDArray as $cxcDA) {

			if($cxcDA != null && $cxcDA->apply != null) {

			    $cxcD = new CxcD;
				$cxcD->fill((array)$cxcDA);
				$cxcD->row = $rowNum++ * $ROW_MULTIPLIER;
				$cxcD->office = $user->getSelectedOffice();
				$cxcD->origin_office = $user->getSelectedOffice();
				if($cxcDA->tableRowID == $clickedRow){
					$tableRowID = $cxcD->row;
				}
				$cxc->details()->save($cxcD);

			}
		}

		$action = \Input::get('action');
		Cxc::setSessionMovID($cxc->ID);
		switch ($action) {
			case 'new':
				Cxc::removeSessionMovID($cxc->ID);
				return redirect('cxc/movimiento/nuevo');
				break;
			case 'open':
				return redirect('cxc/movimiento/abrir');
				break;
			case 'searchClientOffice':
				return redirect('cxc/movimiento/mov/'.$cxc->ID.'/buscar/sucursal-cliente');
				break; 
			case 'searchMovReference':
				return redirect('cxc/movimiento/mov/'.$cxc->ID.'/buscar/referencia-movimiento');
				break;
			case 'showClientBalance':
				return redirect('cxc/movimiento/mov/'.$cxc->ID.'/consultar/saldo-cliente');
				break;
			case 'searchConsecutive':
				if($tableRowID)
				return redirect('cxc/movimiento/mov/'.$cxc->ID.'/buscar/documento/'.$tableRowID);
				else{
					return redirect()->back()->withInput()->withErrors([
						'Apply'=>'Es necesario seleccionar un Aplica.',
					]);
				} 
				break;
			case 'resultCalculator':
				return redirect('cxc/movimiento/mov/'.$cxc->ID.'#documentos');
			case 'affect':
				return redirect('cxc/movimiento/affect');
				break;	 
			case 'save':
			default:
				return redirect('cxc/movimiento/mov/'.$cxc->ID);
				break;
		}
		return redirect('cxc/movimiento/mov/'.$cxc->ID);
	}

	public function postDelete(){

		// Se debe tener un movimiento abierto para poder eliminar.
		if(!Cxc::hasSessionMovID()){
			return redirect()->back()->withInput()->withErrors([
				'Mov'=>'Debes abrir el movimiento que quieres eliminar.',
			]);
		}

		// Se obtiene el ID del movimiento abierto.
		$movID = Cxc::getSessionMovID();

		// Se obtiene el movimiento abierto.
		$cxc = Cxc::findOrFail($movID);

		// El movimiento debe tener el estatus SINAFECTAR para poder ser eliminado.
		if($cxc->status && $cxc->status != 'SINAFECTAR'){
			return redirect()->back()->withInput()->withErrors([
				'Status'=>'Solo puedes eliminar movimientos con estatus \'SINAFECTAR\'.',
			]);
		}

		if($cxc->details()){
			$cxc->details()->delete();
		}

		$cxc->delete();

		Cxc::removeSessionMovID();
		return redirect('cxc/movimiento/nuevo');
	}

	public function postSaveClient(){
		
		//$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('clientID'), [
			'clientID' => 'required',
		]);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors(['clientID','Se requiere seleccionar un cliente.']);
		}

		//$cxc->client_id = \Input::get('clientID');

		\Session::flash('selected_client_id', \Input::get('clientID'));

		//$cxc->save();

		return redirect('cxc/movimiento/nuevo');
	}

	

	public function postSaveClientOffice($movID){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('clientOfficeID'), [
			'clientOfficeID' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['clientOfficeID','Se requiere seleccionar una sucursal de cliente.']);
		}

		/*$cxc->client_id = \Input::get('clientOfficeID');

		$cxc->save();*/


		//$cxc = Cxc::findOrFail($movID);
		$client = $cxc->client_id;
		//dd($client = $cxc->client_id);

		$selectedOffice = \Input::get('clientOfficeID');
		$clientOffice = CteSendTo::where('Cliente', $client)->where('ID',$selectedOffice)->get();
		if($clientOffice){
			$cxc->client_send_to = $selectedOffice;
			$cxc->save();
		}else{
			return Response::back()->withErrors(['clientOfficeID','Esa sucursal no es de ese cliente']);
		}
		//$clientOffices->name = \Input::get('clientOfficeID');
		//$clientOffices->save();
		//$cxc->client_send_to = \Input::get('clientOfficeID');
		//$cxc->save();

		return redirect('cxc/movimiento/mov/'.$movID);
	}

	public function getMov($movID){

		// Se obtiene el movimiento solicitado
		$mov = Cxc::with('details')->with('client')->findOrFail($movID);

		foreach($mov->details as &$movDetail) {
			$movCompany = $mov->company;
			$apply = $movDetail->apply;
			$apply_id = $movDetail->apply_id;

			if($movCompany && $apply && $apply_id){

				$movDetailOrigin = Cxc::where('Empresa', $movCompany)->where('Mov', $apply)->where('MovID',$apply_id)->first(['Concepto','Referencia','Saldo']);
				$movDetailOrigin->pp_suggest = $movDetail->suggestPP();
				$movDetail->origin = $movDetailOrigin;
			}
		}

		//dd($mov->details->toJson());

		// Se obtiene el usuario autenticado.
		$user = \Auth::user();

		// Se obtiene el nombre de la oficina seleccionada por el usuario en el login.
		// Se utiliza en la impresión del ticket.
		$officeName = Office::find($user->getSelectedOffice())->name;

		$clientBalance = '';
		if($mov->client){
			// Se obtiene el saldo del cliente.
			$clientBalance = $mov->client->balance()->where('Empresa', $user->getSelectedCompany())->where('Moneda','Pesos')->get()->first();
		}
		$clientBalance = json_encode($clientBalance);
		// Se obtienen las opciones de las listas desplegables.
		$movTypeList = MovType::getMovTypeList();
		$currencyList = Mon::getCurrencyList();
		$paymentTypeList = PaymentType::getPaymentTypeList();
		$paymentTypeListChangeAllowed = PaymentType::getPaymentTypeChangeAllowed();
		//if($mov->status =)
		$totalChangeAllowedAmount = $mov->getChangeAllowed();
		
		$movCharges = json_encode($mov->getCharges());

		// Se guarda en la sesión del usuario el ID del movimiento.
		Cxc::setSessionMovID($movID);

		return view('cxc.movement.mov',compact('mov','clientBalance','movTypeList','currencyList','paymentTypeList','user','officeName','movCharges','paymentTypeListChangeAllowed','totalChangeAllowedAmount'));
	}



	/*public function search($movID, $searchType){

		if($searchType == 'cliente'){
			return ClientController::showClientSearch($searchType, $movID);
		}else if ($searchType == 'documento') {
			return DocumentController::showDocumentSearch($searchType, $movID);
		}
	}*/

	public function getMovimientoReferencia($movID){
		
		$cxc = Cxc::findOrFail($movID);
		$client = $cxc->client_id;

		$limit = \Input::get('limit');
		$order = \Input::get('order');
		$sort = \Input::get('sort');
		$offset = \Input::get('offset');
		$search = \Input::get('search');

		$clientOfficesQuery = CxcRef::where('Cliente', $client);//->get();
		//dd($clientOfficesQuery);
		if($search){
			$clientOfficesQuery->where(function ($query) use ($search) {
				$comparator = 'LIKE';
				$search = "%$search%";

				$query->where('Mov', $comparator, $search)
					->orWhere('MovID', $comparator, $search)
					->orWhere(DBTranslations::getColumnName('emission_date'), $comparator, $search)
					->orWhere(DBTranslations::getColumnName('expiration_date'), $comparator, $search)
					->orWhere(DBTranslations::getColumnName('balance'), $comparator, $search);
			});
		}

		if($sort && $order){
			$sort = DBTranslations::getColumnName($sort);
			$clientOfficesQuery->orderBy($sort, $order);
		}

		$clientOffices = $clientOfficesQuery->get(['Mov','MovID','FechaEmision','Vencimiento','Saldo']);
		$numberOfClientOffices = $clientOffices->count();
		
		//$movList = $movListquery ->take($limit)->offset($offset)->get();
		$clientOffices = $clientOffices->slice($offset, $limit);
		
		$result = ['total'=>$numberOfClientOffices,'rows'=>$clientOffices->toArray()];
		//dd($result);

		return response()->json($result);
	}

	public static function showMovementReferenceSearch($movID){
		$searchType = 'referencia';
		$dataURL = '/cxc/movimiento/movimiento-referencia/'.$movID;
		
		return view('cxc.movement.searchMovReference', compact('searchType','dataURL','movID'));
	}

	public function getListaMovimientos(){

		$user = \Auth::user();
		$company = $user->getSelectedCompany();
		$username = $user->username;
		
		$limit = \Input::get('limit');
		$order = \Input::get('order');
		$sort = \Input::get('sort');
		$offset = \Input::get('offset');
		$search = \Input::get('search');

		$movListquery = Cxc::where(function ($query) {
			$query->where('Mov', 'Cobro')
				->orWhere('Mov', 'Anticipo');
		})->where('Empresa',$company)
		  ->where('Usuario',$username);

		if($search){
			$movListquery->where(function ($query) use ($search) {
				$comparator = 'LIKE';
				$search = "%$search%";

				$query->where('Mov', $comparator, $search)
					->orWhere('MovID', $comparator, $search)
					->orWhere(DBTranslations::getColumnName('concept'), $comparator, $search)
					->orWhere(DBTranslations::getColumnName('client_id'), $comparator, $search)
					->orWhere(DBTranslations::getColumnName('status'), $comparator, $search)
					->orWhere(DBTranslations::getColumnName('emission_date'), $comparator, $search)
					->orWhere('ID', $comparator, $search)
					->orWhere(\DB::raw('(Importe+Impuestos)'), $comparator, $search);
			});
		}

		//$numberOfDocuments = $movListquery->get(['ID','Mov','MovID','Concepto','Cliente','Estatus','FechaEmision','Importe','Impuestos'])->count();

		if($sort && $order){
			if($sort !='total_amount'){
				$sort = DBTranslations::getColumnName($sort);
			}
			else {
				$sort = \DB::raw('(Importe+Impuestos)');
			}
			$movListquery->orderBy($sort, $order);
		}

		$movList = $movListquery->get(['ID','Mov','MovID','Concepto','Cliente','Estatus','FechaEmision','Importe','Impuestos']);
		$numberOfDocuments = $movList->count();

		//$movList = $movListquery ->take($limit)->offset($offset)->get();
		$movList = $movList->slice($offset, $limit);

		$result = ['total'=>$numberOfDocuments,'rows'=>$movList->toArray()];

		return response()->json($result);
	}

	public static function showMovementSearch(){
		$searchType = 'movimiento';
		$dataURL = '/cxc/movimiento/lista-movimientos/';
		
		return view('cxc.movement.open', compact('searchType','dataURL'));
	}


	public function postOpenSelectedMov(){
		

		//$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('movID'), [
			'movID' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['movID','Se requiere seleccionar un movimiento.']);
		}

		$movID = \Input::get('movID');

		//$cxc->save();

		return redirect('cxc/movimiento/mov/'.$movID);
	}

	public function postSaveMovementReference($movID){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('movReferenceID'), [
			'movReferenceID' => 'required',
		]);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors(['movReferenceID','Se requiere seleccionar una referencia.']);
		}

		$cxc->reference = \Input::get('movReferenceID');

		$cxc->save();

		return redirect('cxc/movimiento/mov/'.$movID);
	}

	public function postSaveDocument($movID, $row){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('json-documents'), [
			'json-documents' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['json-documents','Se requiere seleccionar un documento.']);
		}

		$jsonDocuments = \Input::get('json-documents');
		$selectedDocuments = json_decode($jsonDocuments);
		$firstDocument = true;
		$cxcDLength = $cxc->details->count();
		$cxcD = $cxc->details()->where('Renglon', '=', $row)->first();

		foreach ($selectedDocuments as $document) {

			if(!$firstDocument){
				$cxcDLength++;
				$cxcD->row = $cxcDLength * 2048;
				$cxcD->apply_id = $document->movID;
				$cxcD->amount = $document->balance;
				$cxcD->insertRow();				
			}
			else {
				
				$cxcD->apply_id = $document->movID;
				$cxcD->amount = $document->balance;
				$cxcD->updateRow();

				$firstDocument = false;
			}
		}

		return redirect('cxc/movimiento/mov/'.$movID.'/#documentos');
	}

	public function getConceptList($movType){

		$conceptList = [];

		$user = \Auth::user();
		$company = $user->getSelectedCompany();
		$userID = $user->id;

		$stmt = \DB::getPdo()->prepare('EXEC spThoConceptosCxcWeb ?, ?, ?');

		$stmt->bindParam(1, $company);
		$stmt->bindParam(2, $movType);
		$stmt->bindParam(3, $userID);

		$stmt->execute();

		if($result = $stmt->fetchAll(\PDO::FETCH_OBJ)){
	    	$conceptList = $result;
	    }
	    else{
	    	$conceptList = Concept::where('Modulo','CXC')->get();
	    }

		return response()->json($conceptList);
	}


	public function getApplyList($client){

		$applyList = [];

		if($client){

			$applys = \DB::table('CxcPendiente')
	        	->join('ThoUsuarioAcceso', 'CxcPendiente.Mov', '=', 'ThoUsuarioAcceso.Mov')
		        ->distinct()
		        ->select('CxcPendiente.Mov as apply')
		        ->where('Modulo','CXC')
		        ->where('Empresa',\Auth::user()->getSelectedCompany())
		        ->where('Cliente',$client)
		        ->get();

		    foreach ($applys as $apply) {
		    	$applyList[] = $apply->apply;
		    }
		}

		return response()->json($applyList);
	}

	public function getAffect(){
	
		$movID = Cxc::getSessionMovID();
		$username = \Auth::user()->username;
		$action = 'AFECTAR';

		if(!$movID) {
			return redirect()->back()->withInput()->withErrors([
				'MovID'=>'No hay un movimiento abierto.',
			]);
		}

		if(!$username) {
			return redirect()->back()->withInput()->withErrors([
				'User'=>'No hay un usuario autenticado.',
			]);
		}

		$cxc = Cxc::find($movID);
		if(!$cxc) {
			return redirect()->back()->withInput()->withErrors([
				'Mov'=>'El movimiento '.$movID.' ya no existe.',
			]);
		}
		// El movimiento debe tener el estatus SINAFECTAR o PENDIENTE para poder ser eliminado.
		if($cxc->status != 'SINAFECTAR' && $cxc->status != 'PENDIENTE'){
			return redirect()->back()->withInput()->withErrors([
				'Status'=>'Solo puedes AFECTAR movimientos con estatus \'SINAFECTAR\' o \'PENDIENTE\'.',
			]);
		}

		$result = Cxc::affect($movID, $username, $action);

		if(!$result){
			return redirect()->back()->withInput()->withErrors([
				'Affect'=>'No se pudo afectar el movimiento.',
			]);
		}

		$message = new \stdClass();
		if($result['message'] == null){
			$message->type = 'INFO';
			$message->description = 'Movimiento afectado.';
			$message->code = '';
			$message->reference = '';
			return redirect('cxc/movimiento/mov/'.$movID)->withMessage($message);
		}

		$message = MessageList::find($result['message']);
		$message->reference = $result['reference'];

		return redirect('cxc/movimiento/mov/'.$movID)->withMessage($message);
	}

	public function postCancel(){
		
		$movID = Cxc::getSessionMovID();
		$username = \Auth::user()->username;
		$action = 'CANCELAR';

		if(!$movID) {
			return redirect()->back()->withInput()->withErrors([
				'MovID'=>'No hay un movimiento abierto.',
			]);
		}

		if(!$username) {
			return redirect()->back()->withInput()->withErrors([
				'User'=>'No hay un usuario autenticado.',
			]);
		}

		$cxc = Cxc::find($movID);
		if(!$cxc) {
			return redirect()->back()->withInput()->withErrors([
				'Mov'=>'El movimiento '.$movID.' ya no existe.',
			]);
		}
		// El movimiento debe tener el estatus CONCLUIDO O PENDIENTE para poder ser eliminado.
		if($cxc->status != 'CONCLUIDO' && $cxc->status != 'PENDIENTE'){
			return redirect()->back()->withInput()->withErrors([
				'Status'=>'Solo puedes AFECTAR movimientos con estatus \'CONCLUIDO\' o \'PENDIENTE\'.',
			]);
		}

		$result = Cxc::affect($movID, $username, $action);

		if(!$result){
			return redirect()->back()->withInput()->withErrors([
				'Affect'=>'No se pudo cancelar el movimiento.',
			]);
		}

		$message = new \stdClass();
		if($result['message'] == null){
			$message->type = 'INFO';
			$message->description = 'Movimiento cancelado.';
			$message->code = '';
			$message->reference = '';
			return redirect('cxc/movimiento/mov/'.$movID)->withMessage($message);
		}

		$message = MessageList::find($result['message']);
		$message->reference = $result['reference'];

		return redirect('cxc/movimiento/mov/'.$movID)->withMessage($message);
	}
}

