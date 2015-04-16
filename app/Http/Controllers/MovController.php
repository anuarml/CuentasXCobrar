<?php namespace App\Http\Controllers;

class MovController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function index()
	{
		return view('datosGenerales');
	}

}

