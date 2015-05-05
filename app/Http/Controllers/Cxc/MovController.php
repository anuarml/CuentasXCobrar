<?php namespace App\Http\Controllers\Cxc;

use App\Cxc;
use App\CxcD;
use App\Http\Controllers\Controller;

class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getNuevo(){
		
		return view('cxc.movement.new');
	}

	public function postGuardarNuevo(){

		//$cxcArray = Input Json from the view.
		//$cxcArray = Cxc::findOrFail(123)->toArray();
		//$cxcDArray = CxcD::where('id','123')->get()->toArray();

		$cxc = new Cxc;
		$cxc->fill(array_except($cxcArray, ['ID']));
		$cxc->save();

		foreach ($cxcDArray as $cxcda) {
		    $cxcD = new CxcD;
			$cxcD->fill($cxcda);
			$cxc->details()->save($cxcD);
		}

		return redirect('cxc/movimiento/mov/'.$cxc->id);
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
}

