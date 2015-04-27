<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UtileriesController extends Controller {

	public function getCalculator(){
		
		return view('calculator');
	}

	public function postCalculator(){

	} 
}
