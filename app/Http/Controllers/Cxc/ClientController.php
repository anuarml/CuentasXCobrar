<?php namespace App\Http\Controllers\Cxc;

use App\Http\Controllers\Controller;

class ClientController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getSearch(){
		
		return view('cxc.client.search');
	}
}

