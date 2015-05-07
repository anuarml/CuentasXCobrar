<?php namespace App\Http\Controllers\Cxc;

use App\Cxc;
use App\CxcD;
use App\CxcRef;
use App\Http\Controllers\Controller;



class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getNuevo(){
		
		return view('cxc.movement.new');
	}

	public function postGuardarNuevo(){

		$cxcArray = \Input::except('documentsJson');
		$cxcDArray = json_decode(\Input::get('documentsJson'));

		$user = \Auth::user();

		$cxc = new Cxc;
		$cxc->fill($cxcArray);
		$cxc->company = \Session::get('company');
		$cxc->office_id = \Session::get('office');
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

	public function postDelete($movID){
		$cxc = Cxc::findOrFail($movID);
		$cxc->delete();
	}

	public function postSaveClient($movID){
		
		$cxc = Cxc::findOrFail($movID);

		$validator = \Validator::make(\Input::only('clientID'), [
			'clientID' => 'required',
		]);

		if($validator->fails()){
			return Response::back()->withErrors(['clientID','Se requiere seleccionar un cliente.']);
		}

		$cxc->client_id = \Input::get('clientID');

		$cxc->save();

		return redirect('cxc/movimiento/mov/'.$movID);
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

	/*public function postSaveClientOffice($movID){
		
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
	}*/

	public function getMov($movID){

		$mov = Cxc::with('details')->findOrFail($movID);

		//dd($mov->toJson());

		return view('cxc.movement.new',compact('mov'));
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
		$searchType = 'movimiento-referencia';
		$dataURL = '/cxc/movimiento/movimiento-referencia/'.$movID;
		
		return view('cxc.movement.searchMovReference', compact('searchType','dataURL','movID'));
	}

	/*public function postSaveMovementReference($movID){
		
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
	}*/
}

