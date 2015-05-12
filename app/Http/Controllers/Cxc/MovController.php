<?php namespace App\Http\Controllers\Cxc;

use App\Cxc;
use App\CxcD;
use App\CxcRef;
use App\Concept;
use App\Client;
use App\Mon;
use App\MovType;
use App\PaymentType;
use App\Http\Controllers\Controller;



class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getNuevo(){

		$clientName = '';

		if(\Session::has('selected_client_id')) {

			$userID = \Session::get('selected_client_id');
			$clientName = Client::find($userID)->name;
		}
		
		return view('cxc.movement.new', compact('clientName'));
	}

	public function postGuardarNuevo(){

		$cxcArray = \Input::except('documentsJson');
		$cxcDArray = json_decode(\Input::get('documentsJson'));

		$user = \Auth::user();

		$cxc = new Cxc;
		$cxc->fill($cxcArray);
		$cxc->company = $user->getSelectedCompany();
		$cxc->office_id = $user->getSelectedOffice();
		$cxc->currency = $user->defCurrency->currency;
		$cxc->save();

		$ROW_MULTIPLIER = 2048;
		$rowNum = 1;

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
			return Response::back()->withErrors(['clientID','Se requiere seleccionar un cliente.']);
		}

		//$cxc->client_id = \Input::get('clientID');

		\Session::flash('selected_client_id', \Input::get('clientID'));

		//$cxc->save();

		return redirect('cxc/movimiento/nuevo');
	}

	public function postSaveDocument($movID){
		
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
	}

	public function postSaveClientOffice($movID){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('clientOfficeID'), [
			'clientOfficeID' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['clientOfficeID','Se requiere seleccionar una sucursal de cliente.']);
		}

		$cxc->client_id = \Input::get('clientOfficeID');

		$cxc->save();

		return redirect('cxc/movimiento/mov/'.$movID);
	}

	public function getMov($movID){

		$mov = Cxc::with('details')->with('client')->findOrFail($movID);
		$user = \Auth::user();

		$clientBalance = $mov->client->balance()->where('Empresa', $user->getSelectedCompany())->where('Moneda','Pesos')->get()->first();
		//dd($clientBalance);
		$movTypeList = MovType::getMovTypeList();

		$currencyList = Mon::getCurrencyList();

		$paymentTypeList = PaymentType::getPaymentTypeList();

		return view('cxc.movement.mov',compact('mov','clientBalance','movTypeList','currencyList','paymentTypeList'));
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

		$clientOffices = CxcRef::where('Cliente', $client);

		return response()->json($clientOffices);
	}

	public static function showMovementReferenceSearch($movID){
		$searchType = 'movimiento-referencia';
		$dataURL = '/cxc/movimiento/movimiento-referencia/'.$movID;
		
		return view('cxc.movement.searchMovReference', compact('searchType','dataURL','movID'));
	}

	public function postMovementReference($movID){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('movReferenceID'), [
			'movReferenceID' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['movReferenceID','Se requiere seleccionar una referencia.']);
		}

		$cxc->client_id = \Input::get('movReferenceID');

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
}

