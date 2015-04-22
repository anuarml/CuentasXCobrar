<?php namespace App\Http\Controllers\Cxc;

use App\Http\Controllers\Controller;

class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getNuevo(){
		
		return view('datosGenerales');
	}

	public function postNuevo(){

	}
}

