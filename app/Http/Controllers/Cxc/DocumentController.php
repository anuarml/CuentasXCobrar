<?php namespace App\Http\Controllers\Cxc;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CxcPending;
use App\Cxc;
use App\DBTranslations;

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

		//$cxc = Cxc::findOrFail($movID);
		//$apply = $cxc->details->find($row)->apply;
		//$company = $cxc->company;
		//$client = $cxc->client_id;

		//$documents = CxcPending::where ('Mov', $apply) -> where ('Empresa', $company) -> where ('Cliente', $client) -> get();

		//return response()->json($documents);

		$limit = \Input::get('limit');
		$order = \Input::get('order');
		$sort = \Input::get('sort');
		$offset = \Input::get('offset');
		$search = \Input::get('search');

		$cxc = Cxc::findOrFail($movID);
		$apply = $cxc->details->find($row)->apply;
		$company = $cxc->company;
		$client = $cxc->client_id;

		$documentsQuery = CxcPending::where('Mov', $apply) -> where('Empresa', $company) -> where('Cliente', $client);

		if($search){
			$documentsQuery->where(function ($query) use ($search) {
				$comparator = 'LIKE';
				$search = "%$search%";

				$query->where('MovID', $comparator, $search)
					->orWhere('FechaEmision', $comparator, $search)
					->orWhere('Vencimiento', $comparator, $search)
					->orWhere('ImporteTotal', $comparator, $search)
					->orWhere('Saldo', $comparator, $search)
					->orWhere('Concepto', $comparator, $search);
			});
		}

		if($sort && $order){
			$sort = DBTranslations::getColumnName($sort);
			$documentsQuery->orderBy($sort, $order);
		}

		$documentList = $documentsQuery->get(['Mov','MovID','FechaEmision','Vencimiento','ImporteTotal','Saldo','Concepto']);
		$numberOfDocuments = $documentList->count();

		$documentList = $documentList->slice($offset, $limit);

		$result = ['total'=>$numberOfDocuments,'rows'=>$documentList->toArray()];

		return response()->json($result);
	}

	public static function showDocumentSearch($movID, $searchType, $row){
		
		$dataURL = '/cxc/documento/documentos/'.$movID .'/' .$row;
		
		return view('cxc.document.search', compact('searchType','dataURL','movID','row'));
	}
}
