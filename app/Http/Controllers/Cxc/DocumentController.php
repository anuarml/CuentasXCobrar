<?php namespace App\Http\Controllers\Cxc;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CxcPending;

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

	public function getDocumentos(){
		$apply = Mov;
		$company = s;
		$client = d ;
		$documents = CxcPending::where ('Mov', $apply) -> where ('Empresa', $company) -> where ('Cliente', $client);

		//dd($documents);

		return response()->json($documents);
	}

	public static function showDocumentSearch($searchType, $movID){
		
		$dataURL = '/cxc/documento/documentos';
		
		return view('cxc.document.search', compact('searchType','dataURL','movID'));
	}
}
