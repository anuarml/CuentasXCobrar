<?php namespace App\Http\Controllers\Cxc;

use App\Cxc;
use App\CxcD;
use App\CxcRef;
use App\Concept;
use App\Client;
use App\CteSendTo;
use App\CxcPending;
use App\Mon;
use App\MovType;
use App\Office;
use App\PaymentType;
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

		// Se obtiene el nombre de la oficina seleccionada por el usuario en el login.
		// Se utiliza en la impresión del ticket.
		$officeName = Office::find($user->getSelectedOffice())->name;

		// Se obtienen las opciones de las listas desplegables.
		$movTypeList = MovType::getMovTypeList();
		$currencyList = Mon::getCurrencyList();
		$paymentTypeList = PaymentType::getPaymentTypeList();
		
		//return view('cxc.movement.new', compact('clientName'));
		return view('cxc.movement.mov', compact('mov', 'user', 'clientBalance','officeName','movTypeList','currencyList','paymentTypeList'));
	}

	public function postNuevo(){
		Cxc::removeSessionMovID();
		return redirect('cxc/movimiento/nuevo');
	}

	public function postGuardar(){

		$movID = Cxc::getSessionMovID();

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
		]);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors([
				'Mov'=>'Es necesario seleccionar un Movimiento.',
				'currency'=>'Es necesario seleccionar una Moneda.',
				'client_id'=>'Es necesario seleccionar un Cliente.',
			]);
		}

		//$cxc = new Cxc;
		$cxc = Cxc::findOrNew($movID);
		$cxc->fill($cxcArray);
		$cxc->company = $user->getSelectedCompany();
		$cxc->office_id = $user->getSelectedOffice();
		$cxc->origin_office_id = $user->getSelectedOffice();
		//$cxc->currency = $user->defCurrency->currency;
		$cxc->manual_apply = true;
		$cxc->with_breakdown = true;
		$cxc->status = 'SINAFECTAR';
		$cxc->last_change = Carbon::now()->format('d/m/Y');

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
				if($cxcDA->tableRowID == $clickedRow){
					$tableRowID = $cxcD->row;
				}
				$cxc->details()->save($cxcD);

			}
		}

		$action = \Input::get('action');
		switch ($action) {
			case 'new':
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
			case 'save':
			default:
				return redirect('cxc/movimiento/mov/'.$cxc->ID);
				break;
		}
		return redirect('cxc/movimiento/mov/'.$cxc->ID);
	}

	public function postActualizar($movID){

		$cxcArray = \Input::except('documentsJson');
		$cxcDArray = json_decode(\Input::get('documentsJson'));

		$user = \Auth::user();

		$cxc = findOrFail($movID);
		$cxc->fill($cxcArray);
		$cxc->company = $user->getSelectedCompany();
		$cxc->office_id = $user->getSelectedOffice();
		$cxc->currency = $user->defCurrency->currency;
		$cxc->save();

		$ROW_MULTIPLIER = 2048;
		$rowNum = 1;

		//Borrar todos los detalles y luego insertarlos de nuevo.

		foreach ($cxcDArray as $cxcDA) {

			if($cxcDA != null && $cxcDA->apply != null) {

			    $cxcD = new CxcD;
				$cxcD->fill((array)$cxcDA);
				$cxcD->row = $rowNum++ * $ROW_MULTIPLIER;
				$cxc->details()->save($cxcD);
			}
		}

		return redirect('cxc/movimiento/mov/'.$cxc->ID);
	}

	public function postDelete($movID){
		$cxc = Cxc::findOrFail($movID);
		$cxc->delete();
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

	/*public function postSaveDocument($movID){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('movID'), [
			'movID' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['movID','Se requiere seleccionar un documento.']);
		}

		$cxc->client_id = \Input::get('movID');

		$cxc->save();

		return redirect('cxc/movimiento/mov/'.$movID);
	}*/

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
		// Se obtienen las opciones de las listas desplegables.
		$movTypeList = MovType::getMovTypeList();
		$currencyList = Mon::getCurrencyList();
		$paymentTypeList = PaymentType::getPaymentTypeList();

		// Se guarda en la sesión del usuario el ID del movimiento.
		Cxc::setSessionMovID($movID);

		return view('cxc.movement.mov',compact('mov','clientBalance','movTypeList','currencyList','paymentTypeList','user','officeName'));
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

		$clientOffices = CxcRef::where('Cliente', $client)->get();

		return response()->json($clientOffices);
	}

	public static function showMovementReferenceSearch($movID){
		$searchType = 'referencia';
		$dataURL = '/cxc/movimiento/movimiento-referencia/'.$movID;
		
		return view('cxc.movement.searchMovReference', compact('searchType','dataURL','movID'));
	}

	public function getListaMovimientos(){
		//$movList = Cxc::all();
		$movList = Cxc::where('Mov', 'Cobro')->orWhere('Mov', 'Anticipo')->get();
		//$movList->emission_date = $movList->emission_date->format('d/M/Y');

		return response()->json($movList);
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

}

