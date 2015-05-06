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

	public function getMov($movID){

		$mov = Cxc::with('details')->findOrFail($movID);

		//dd($mov->toJson());

		return view('cxc.movement.new',compact('mov'));
	}

	public function search($movID, $searchType){

		if($searchType == 'cliente'){
			return ClientController::showClientSearch($searchType, $movID);
		}
	}
}

