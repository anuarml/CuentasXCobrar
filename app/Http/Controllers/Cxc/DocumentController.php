<?php namespace App\Http\Controllers\Cxc;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CxcPending;
use App\Cxc;

use Illuminate\Http\Request;

class DocumentController extends Controller {

	public function __construct(){
		$this->middleware('auth');
	}

	/*public function getBuscar(){
		
		return view('cxc.document.search');
	}

	public function postBuscar(){

	} */

	public function getDocumentos($movID, $row){
		/*$apply = Mov;
		$company = s;
		$client = d ;*/
		$cxc = Cxc::findOrFail($movID);
		$apply = $cxc->details->find($row)->apply;
		$company = $cxc->company;
		$client = $cxc->client_id;
		//dd($cxc->company);
		//dd($cxc->client_id);
		$documents = CxcPending::where ('Mov', $apply) -> where ('Empresa', $company) -> where ('Cliente', $client) -> get();

		//dd($documents);

		return response()->json($documents);
	}

	public static function showDocumentSearch($movID, $searchType, $row){
		
		$dataURL = '/cxc/documento/documentos/'.$movID .'/' .$row;
		
		return view('cxc.document.search', compact('searchType','dataURL','movID'));
	}
}
