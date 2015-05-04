<?php namespace App\Http\Controllers\Cxc;

use App\Client;
use App\Http\Controllers\Controller;

class ClientController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getClientes(){
		
		$clients = Client::all();

		return response()->json($clients);
	}

	public static function showClientSearch($movID, $searchType){
		
		$dataURL = '/cxc/cliente/clientes';
		
		return view('cxc.client.search', compact('searchType','dataURL','movID'));
	}
}

	