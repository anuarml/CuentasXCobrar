<?php namespace App\Http\Controllers\Cxc;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DocumentController extends Controller {

	public function __construct(){
		$this->middleware('auth');
	}

	public function getBuscar(){
		
		return view('cxc.document.search');
	}

	public function postBuscar(){

	} 

}
