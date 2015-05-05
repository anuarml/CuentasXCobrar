<?php namespace App\Http\Controllers\Cxc;

use App\Client;
use App\Http\Controllers\Controller;
use App\Cxc;
use App\CteSendTo;

class ClientController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getClientes(){
		
		$clients = Client::all();

		return response()->json($clients);
	}

	public static function showClientSearch($movID){
		$searchType = 'cliente';
		$dataURL = '/cxc/cliente/clientes';
		
		return view('cxc.client.search', compact('searchType','dataURL','movID'));
	}

	public function getSucursalCliente($movID){
		
		$cxc = Cxc::findOrFail($movID);
		$client = $cxc->client_id;

		$clientOffices = CteSendTo::where('ID', $client);

		return response()->json($clientOffices);
	}

	public static function showClientOfficeSearch($movID){
		$searchType = 'sucursal-cliente';
		$dataURL = '/cxc/cliente/sucursal-cliente/'.$movID;
		
		return view('cxc.client.searchClientOffice', compact('searchType','dataURL','movID'));
	}
}

	