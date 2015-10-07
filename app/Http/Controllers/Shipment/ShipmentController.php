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

	/*
		Se utiliza el agente que tenga configurado el usuario para obtener el embarque(Orden de Cobro) que tiene asignado.
		
		Para ver las facturas o documentos que debe cobrar el usuario:
		  Estas se obtienen mediante el movimiento 'Orden Cobro' (Embarques) en estatus PENDIENTE
		  que tenga asignada el agente configurado en el usuario.

		Para ver las facturas o documentos que ha cobrado el usuario:
		  Estas se obtienen de los movimiento 'Cobro' (CXC) en estatus CONCLUIDO que haya realizado
		  el usuario.
	*/

	public function getEmbarques(){

		$user = \Auth::user();

		$chargeOrderCompare = collect([]);

		// Se obtiene el ID de la orden de cobro asignada al usuario.
		$chargeOrderID = Shipment::getChargeOrdersID();
		// Se obtienen los DOCUMENTOS asignados al usuario en la orden de cobro.
		$assignedDocuments = ShipmentMov::getAsignedDocuments($chargeOrderID);
		// Se obtienen los DOCUMENTOS que ha cobrado el usuario durante la ruta de cobro asignada.
		$chargedDocuments = Cxc::getChargedDocuments($chargeOrderID);
		// Se obtienen los ANTICIPOS que ha cobrado el usuario durante la ruta de cobro asignada.
		$chargedAdvances = Cxc::getChargedAdvances($chargeOrderID);


		foreach ($assignedDocuments as &$assignedDocument) {

			$mov = trim($assignedDocument->Mov);
			$movID = trim($assignedDocument->MovID);

			$documentOrigin = Cxc::where('Mov',$mov)->where('MovID',$movID)->where('Empresa',$user->getSelectedCompany())->first(['Saldo','Cliente']);

			$document = new \stdClass;

			if($documentOrigin){
				$document->balance = $documentOrigin->balance;
			} else{
				$document->balance = 0;
			}
			$document->client = $assignedDocument->client;
			$document->assigned = 1;
			$document->charged = false;
			$document->cashed = 0;
			$document->mov = $mov;
			$document->movID = $movID;
			
			foreach ($chargedDocuments as &$chargedDocument) {

				$apply = trim($chargedDocument->apply);
				$applyID = trim($chargedDocument->apply_id);

				if( $mov == $apply && $movID == $applyID ){
					$document->charged = true;
					$document->cashed += $chargedDocument->amount;
					$chargedDocument->assigned = 1;
				}
			}

			$chargeOrderCompare->push($document);
		}


		// Se obtienen los documentos que se cobraron y no estaban asignados.
		$unassignedChargedDocuments = $chargedDocuments->where('assigned',null);

		foreach ($unassignedChargedDocuments as &$unassignedChargedDocument) {
			
			$apply = trim($unassignedChargedDocument->apply);
			$apply_id = trim($unassignedChargedDocument->apply_id);

			$coincidence = $chargeOrderCompare->where('mov',$apply)->where('movID',$apply_id);

			if( $coincidence->isEmpty() ){

				$documentOrigin = Cxc::where('Mov',$apply)->where('MovID',$apply_id)->where('Empresa',$user->getSelectedCompany())->first(['Saldo','Cliente']);

				$document = new \stdClass;
				if($documentOrigin){
					$document->balance = $documentOrigin->balance;
					$document->client = $documentOrigin->client_id;

					if($apply == Cxc::getAdvanceName()){
						$document->assigned = 2;
					}
				} else{
					$document->balance = 0;
					$document->client = null;
					$document->assigned = 0;
				}
				
				$document->charged = true;
				$document->cashed = $unassignedChargedDocument->amount;
				//$document->balance = $documentOrigin->balance;
				//$document->client = $documentOrigin->client_id;
				$document->mov = $apply;
				$document->movID = $apply_id;

				$chargeOrderCompare->push($document);
			}
			else{
				$coincidence->first()->cashed += $unassignedChargedDocument->amount;
			}
		}

		foreach ($chargedAdvances as $advance) {
			$document = new \stdClass;

			$document->balance = $advance->balance;
			$document->client = $advance->client_id;
			$document->assigned = 2;
			$document->charged = true;
			$document->cashed = $advance->total_amount;
			$document->mov = $advance->Mov;
			$document->movID = $advance->MovID;

			$chargeOrderCompare->push($document);
		}

		//$chargeOrderCompare->sum('cashed');

		//dd([$assignedDocuments,$unassignedChargedDocuments]);
		//dd($chargeOrderCompare);
		return response()->json($chargeOrderCompare);
	}

	public static function showShipmentDocuments(){
		
		$dataURL = 'embarques/embarques';
		
		return view('shipment.shipmentDocuments', compact('dataURL'));
	}
}
