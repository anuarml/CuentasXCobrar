<?php namespace App\Http\Controllers\Cxc;

use App\Cxc;
use App\Http\Controllers\Controller;

class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getNuevo(){
		
		return view('nuevoMovimiento');
	}

	public function postNuevo(){

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

	public function getMov($id){
		return $id;
	}

	public function search($movID, $searchType){

		if($searchType == 'cliente'){
			return ClientController::showClientSearch($searchType, $movID);
		}
	}
}

