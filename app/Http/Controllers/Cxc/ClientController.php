<?php namespace App\Http\Controllers\Cxc;

use App\Client;
use App\Http\Controllers\Controller;
use App\Cxc;
use App\CteSendTo;
use App\CxcInfo;
use App\DBTranslations;

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

		$limit = \Input::get('limit');
		$order = \Input::get('order');
		$sort = \Input::get('sort');
		$offset = \Input::get('offset');
		$search = \Input::get('search');

		$clientBalanceQuery = CxcInfo::where('Empresa', $company) -> where ('Cliente', $client) -> where ('Moneda', $currency);

		if($search){
			$clientBalanceQuery->where(function ($query) use ($search) {
				$comparator = 'LIKE';
				$search = "%$search%";

				$query->where('Mov', $comparator, $search)
					->orWhere('MovID', $comparator, $search)
					->orWhere('Vencimiento', $comparator, $search)
					->orWhere('DiasMoratorios', $comparator, $search)
					->orWhere('Saldo', $comparator, $search);
			});
		}

		if($sort && $order){
			$sort = DBTranslations::getColumnName($sort);
			$clientBalanceQuery->orderBy($sort, $order);
		}

		$clientBalanceList = $clientBalanceQuery->get(['Mov','MovID','Vencimiento','DiasMoratorios','Saldo']);
		$numberOfClientBalances = $clientBalanceList->count();

		$clientBalanceList = $clientBalanceList->slice($offset, $limit);

		$result = ['total'=>$numberOfClientBalances,'rows'=>$clientBalanceList->toArray()];

		return response()->json($result);
	}

	public static function showClientBalance($movID){
		
		$dataURL = '/cxc/cliente/saldo-cliente/'.$movID;
		
		return view('cxc.client.showClientBalance', compact('dataURL','movID'));
	}
}

	