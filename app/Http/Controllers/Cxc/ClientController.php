<?php namespace App\Http\Controllers\Cxc;

use App\Client;
use App\Http\Controllers\Controller;
use App\Cxc;
use App\CteSendTo;
use App\CxcInfo;

class ClientController extends Controller {
	
	public function __construct(){
		$this->middleware('auth');
	}

	public function getClientes(){
		
		$limit = \Input::get('limit');
		$order = \Input::get('order');
		$sort = \Input::get('sort');
		$offset = \Input::get('offset');
		$search = \Input::get('search');

		$clientsQuery = Client::query();

		if($search){
			$clientsQuery->where(function ($query) use ($search) {
				$comparator = 'LIKE';
				$search = "%$search%";

				$query->where('Cliente', $comparator, $search)
					->orWhere('Nombre', $comparator, $search)
					->orWhere('RFC', $comparator, $search);
			});
		}

		if($sort && $order){
			$sort = DBTranslations::getColumnName($sort);
			$clientsQuery->orderBy($sort, $order);
		}

		$clientList = $clientsQuery->get(['Cliente','Nombre','RFC']);
		$numberOfClients = $clientList->count();

		$clientList = $clientList->slice($offset, $limit);

		$result = ['total'=>$numberOfClients,'rows'=>$clientList->toArray()];

		return response()->json($result);
	}

	public static function showClientSearch(){

		$searchType = 'cliente';
		$dataURL = '/cxc/cliente/clientes';
		
		return view('cxc.client.search', compact('searchType','dataURL'));
	}

	public function getSucursalCliente($movID){
		
		$cxc = Cxc::findOrFail($movID);
		$client = $cxc->client_id;
		//dd($client = $cxc->client_id);
		
		$clientOffices = CteSendTo::where('Cliente', $client)->get();
		//dd($clientOffices);
		return response()->json($clientOffices);
	}

	public static function showClientOfficeSearch($movID){
		$searchType = 'sucursal-cliente';
		$dataURL = '/cxc/cliente/sucursal-cliente/'.$movID;
		
		return view('cxc.client.searchClientOffice', compact('searchType','dataURL','movID'));
	}

	public function getSaldoCliente($movID){
		
		$cxc = Cxc::findOrFail($movID);
		$company = $cxc->company;
		$client = $cxc->client_id;
		$currency = $cxc->currency;
		//dd([$company,]);
		$clientBalance = CxcInfo::where('Empresa', $company) -> where ('Cliente', $client) -> where ('Moneda', $currency)->get();
		//dd($clientBalance);
		return response()->json($clientBalance);
	}

	public static function showClientBalance($movID){
		
		$dataURL = '/cxc/cliente/saldo-cliente/'.$movID;
		
		return view('cxc.client.showClientBalance', compact('dataURL','movID'));
	}
}

	