<?php namespace App\Http\Controllers\Cxc;

use App\Client;
use App\Http\Controllers\Controller;

class ClientController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getBuscar(){
		
		$searchType = 'Cliente';

		return view('cxc.client.search', compact('searchType'));
	}

	public function getClientes(){
		
		$clients = Client::all();

		//dd($clients); 
		return response()->json($clients);
	}
}

