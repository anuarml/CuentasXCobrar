<?php namespace App\Http\Controllers\Shipment;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cxc;
use App\CxcD;
use App\CxcPending;
use App\Shipment;
use App\ShipmentMov;

class ShipmentController extends Controller {

	public function __construct(){
		$this->middleware('auth');
	}

	public function getEmbarques(/*$movID*/){
		
		/*$cxc = Cxc::findOrFail($movID);
		$cxcD = CxcD::findOrFail($movID);
		$cxcPending = CxcPending::findOrFail($movID);
		$shipment = Shipment::findOrFail($movID);
		$shipmentMov = ShipmentMov::findOrFail($movID);*/
		$company = 'ASSIS';
		$user = 'ADMIN';
		$shipmentID = 3;
		$status = 'CONCLUIDO';
		$agent = 'Secreto';
		$module = 'Cxc';


		$cxc =  \DB::table('Cxc') -> join('CxcD', 'Cxc.id', '=', 'CxcD.id') -> leftJoin('CxcPendiente', function($leftJoin) use ($company, $user, $shipmentID, $status){

				/*$leftJoin->on('CxcD.aplica', '=', 'CxcPendiente.Mov') -> on('CxcD.aplicaID', '=', 'CxcPendiente.MovID') -> on('Cxc.Empresa', '=', 'CxcPendiente.Empresa') -> on('CxcPendiente.Cliente', '=', 'Cxc.Cliente') -> where('Cxc.Empresa', '=',  DB::raw('"'.$company.'"')) -> where ('Usuario', '=', DB::raw('"'.$user.'"')) -> where('ThoAsignadoWeb', '=', DB::raw('"'.$shipmentID.'"')) -> where('Cxc.Estatus', '=', DB::raw('"'.$status.'"'));*/
				$leftJoin -> on('CxcD.aplica', '=', 'CxcPendiente.Mov');
				$leftJoin -> on('CxcD.aplicaID', '=', 'CxcPendiente.MovID');
				$leftJoin -> on('Cxc.Empresa', '=', 'CxcPendiente.Empresa');
				$leftJoin -> on('CxcPendiente.Cliente', '=', 'Cxc.Cliente');
				$leftJoin -> where('Cxc.Empresa', '=',  $company);
				$leftJoin -> where ('Usuario', '=', $user);
				$leftJoin -> where('ThoAsignadoWeb', '=', $shipmentID);
				$leftJoin -> where('Cxc.Estatus', '=', $status);

			})->get();
		//dd($cxc);

		$shipmentMov = ShipmentMov::where('AsignadoID', $shipmentID)->get();
		//dd($shipmentMov);

		$shipmentMov2 = \DB::table('Embarque') -> join('EmbarqueMov', 'Embarque.ID', '=', 'EmbarqueMov.AsignadoID') -> leftJoin('CxcPendiente', function($leftJoin) use ($shipmentID, $company, $agent, $module){
			
			/*$join->on('Embarque.ID', '=', 'EmbarqueMov.AsignadoID') -> leftJoin('CxcPendiente', function($leftJoin){
				$leftJoin->on('EmbarqueMov.Mov', '=', 'CxcPendiente.Mov') -> on('EmbarqueMov.MovID', '=', 'CxcPendiente.MovID') -> on('EmbarqueMov.Empresa', '=', 'CxcPendiente.Empresa') -> on('CxcPendiente.Cliente', '=', 'EmbarqueMov.Cliente') -> where('AsignadoID', '=', DB::raw('"'.$shipmentID.'"')) -> where('EmbarqueMov.Empresa', '=', DB::raw('"'.$company.'"')) -> where('Embarque.Agente', '=', DB::raw('"'.$agent.'"')) -> where('EmbarqueMov', DB::raw('"'.$module.'"'));*/

				$leftJoin -> on('EmbarqueMov.Mov', '=', 'CxcPendiente.Mov');
				$leftJoin -> on('EmbarqueMov.MovID', '=', 'CxcPendiente.MovID');
				$leftJoin -> on('EmbarqueMov.Empresa', '=', 'CxcPendiente.Empresa');
				$leftJoin -> on('CxcPendiente.Cliente', '=', 'EmbarqueMov.Cliente');
				$leftJoin -> where('AsignadoID', '=', $shipmentID);
				$leftJoin -> where('EmbarqueMov.Empresa', '=', $company);
				$leftJoin -> where('Embarque.Agente', '=', $agent);
				$leftJoin -> where('EmbarqueMov.Modulo', '=', $module);

			})->get();
		//dd($shipmentMov2);

		$cxc2 = \DB::table('Cxc') -> join('CxcD', function($join) use ($company, $user, $shipmentID, $status){
			
			/*$join->on('Cxc.id', '=', 'CxcD.id') -> where('Cxc.Empresa', '=', DB::raw('"'.$company.'"')) -> where ('Usuario', '=', DB::raw('"'.$user.'"')) -> where('ThoAsignadoWeb', '=', DB::raw('"'.$shipmentID.'"')) -> where('Cxc.Estatus', '=', DB::raw('"'.$status.'"'));*/

			$join -> on('Cxc.id', '=', 'CxcD.id');
			$join -> where('Cxc.Empresa', '=', $company);
			$join -> where ('Usuario', '=', $user);
			$join -> where('ThoAsignadoWeb', '=', $shipmentID);
			$join -> where('Cxc.Estatus', '=', $status);

		})->get();

		//dd($cxc2);

		$amount = 

		//$shipmentDocuments = CxcInfo::where('Empresa', $company) -> where ('Cliente', $client) -> where ('Moneda', $currency)->get();

		return response()->json($shipmentDocumentst);
	}

	public static function showShipmentDocuments(){
		
		$dataURL = '/embarques';
		
		return view('shipment.shipmentDocuments', compact('dataURL'));
	}
}
