<?php namespace App\Http\Controllers\CorteCaja;

use App\CorteCaja\Dinero;
use App\CorteCaja\DineroSaldo;
use App\PaymentType;
use App\CorteCaja\CtaDinero;
use App\CorteCaja\ListaD;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CorteCajaController extends Controller {

	public function __construct(){
		$this->middleware('auth');
	}


	public function showCorteCaja(){

		$user = \Auth::user();
		$company = $user->getSelectedCompany();
		$moneyAccount = $user->account; // VALIDAR LA CAJA AL INICIAR SESIÓN......

		$currency = config('cxc.default_currency');

		// Se obtiene el saldo de la caja del usuario.
		$dineroSaldo = DineroSaldo::getDineroSaldo($company, $currency, $moneyAccount)
							->get([DineroSaldo::COLUMN_NAME_SALDO])
							->first();
		$saldo = 0;
		if($dineroSaldo){
			$saldo = $dineroSaldo->Saldo;
		}

		//$paymentTypeList = PaymentType::getPaymentTypeList();
		$paymentTypeList = PaymentType::getPaymentTypeSelect();
		//$destinyAccountList = CtaDinero::getDestinyAccountList();
		$destinyAccountList = ListaD::getDestinyAccountList();
		
		$dinID = \Session::get('DineroID');
		$din = Dinero::findOrNew($dinID,Dinero::$COLUMN_NAMES);

		//$din->obtenerReporteCaja();

		$saldoInicial = 0;
		if($din->Importe){
			$saldoInicial = $saldo + $din->Importe;
		}
		
		return view('corteDeCaja.corteCaja', compact('din','saldo','paymentTypeList','destinyAccountList','saldoInicial'));
	}

	public function postGuardar(){

		$dineroID = \Input::get('ID');
		
		$dinero = Dinero::findOrNew($dineroID, Dinero::$COLUMN_NAMES);

		if($dinero->Estatus && $dinero->Estatus != 'SINAFECTAR'){
			return redirect()->back()->withInput()->withErrors([
				'Status'=>'Solo puedes guardar movimientos con estatus \'SINAFECTAR\'.',
			]);
		}

		$dineroInput = \Input::all();

		$validator = \Validator::make($dineroInput, [
			'Importe' => 'required',
			'CtaDineroDestino' => 'required|exists:CtaDinero,CtaDinero',
			'FormaPago' => 'required|exists:FormaPago,FormaPago,CxcWeb,1',
		],
		[
			'Importe.required'			=>'Es necesario ingresar el Depósito.',
			'CtaDineroDestino.required'	=>'Es necesario seleccionar la Cuenta Destino.',
			'FormaPago.required'		=>'Es necesario seleccionar la Forma de Pago.',
		]);

		if($validator->fails()){
			return redirect()->back()->withInput()->withErrors($validator->messages());
		}

		/*
		INSERT INTO Dinero (
		  Empresa,			Mov,			FechaEmision,		UltimoCambio,
		  Concepto,			Moneda,			TipoCambio,			Referencia,
		  Usuario,			Estatus,		Directo,			CtaDinero, 
		  CtaDineroDestino, ConDesglose,	Importe,			FormaPago,	FechaProgramada,
		  Sucursal,			SucursalOrigen,	TipoCambioDestino,	Prioridad,	TasaDias
		)
		VALUES (
		  'ASSIS',		'Corte Caja',	'14/10/2015 00:00:00',	'14/10/2015 13:30:17',
		  NULL,			'Pesos',		1.0,					NULL,  
		  'AQUIJANO',	'SINAFECTAR',	1,						'CJAGE01',
		  'BBVA0667',	0,				100.0,					'Efectivo',	'14/10/2015 13:25:27',
		  0,			0,				1.0,					'Normal',	360
		)
		*/
		$dinero->fill($dineroInput);

		$user = \Auth::user();
		$nowDate = Carbon::now()->format('Y-d-m H:i:s');

		$dinero->Empresa 			= $user->getSelectedCompany();
		$dinero->Mov 				= $dinero->tipo_movimiento;		// Depende de la cuenta destino(CtaDineroDestino)
		$dinero->FechaEmision 		= $nowDate;
		$dinero->UltimoCambio 		= $nowDate;
		$dinero->Concepto 			= $dinero->concepto_omision;	// Depende de (Mov)
		$dinero->Moneda 			= config('cxc.default_currency');
		$dinero->TipoCambio 		= $dinero->tipo_cambio_mon;		// Depende de la (Moneda)
		//$dinero->Referencia 		= ;
		$dinero->Usuario 			= $user->username;
		$dinero->Estatus 			= 'SINAFECTAR';
		$dinero->Directo 			= true;
		$dinero->CtaDinero 			= $user->account;
		$dinero->ConDesglose 		= false;
		$dinero->FechaProgramada 	= $nowDate;
		$dinero->Sucursal 			= $user->getSelectedOffice();
		$dinero->SucursalOrigen 	= $user->getSelectedOffice();
		$dinero->TipoCambioDestino	= $dinero->tipo_cambio_cta_destino;
		$dinero->Prioridad 			= 'Normal';
		$dinero->TasaDias 			= 360;

		if(!$dinero->ID) $dinero->FechaRegistro = $nowDate;

		$dinero->save();


		$action = \Input::get('Accion');

		switch ($action) {
			case 'afectar':
				$resultado = $dinero->afectar($user->username);
				$dinero = Dinero::findOrFail($dinero->ID, Dinero::$COLUMN_NAMES);
				$mensaje   = $dinero->crearMensaje($resultado);

				return redirect('corteCaja')
					->withMensaje($mensaje)
					->with('DineroID', $dinero->ID);
				break;	 
			default:
				$message = new \stdClass();
				$message->type = 'INFO';
				$message->description = 'Movimiento guardado.';
				$message->code = $dinero->ID;
				$message->reference = '';

				$mensaje   = $dinero->crearMensaje($resultado);

				return redirect('corteCaja')
						->withMensaje($mensaje)
						->with('DineroID', $dinero->ID);
				break;
		}
	}

	public function getMovimientosCaja(){
/*
		$limit = \Input::get('limit');
		$order = \Input::get('order');
		$sort = \Input::get('sort');
		$offset = \Input::get('offset');
		$search = \Input::get('search');
*/
		$fechaInicio = \Input::get('fechaInicio');
		$fechaFin = \Input::get('fechaFin');

		$user = \Auth::user();
		$empresa = $user->getSelectedCompany();
        $moneda = config('cxc.default_currency');
        $caja = $user->account;

		$reporteCaja = Dinero::obtenerReporteCaja($empresa, $moneda, $caja, $fechaInicio, $fechaFin);

		foreach ($reporteCaja as &$line) {
			$line->Fecha = (new Carbon($line->Fecha))->formatLocalized('%d/%b/%Y');
		}

		//dd($rep = collect($reporteCaja)/*->where('Periodo','9')*/);

		$result = ['total'=>count($reporteCaja),'rows'=>$reporteCaja];
		//dd($result);

		return response()->json($result);
	}

	public static function showMovimientosCaja(){
		
		$user = \Auth::user();

		$cuenta = $user->account;

		$dataURL = 'corteCaja/movimientos-caja';
		
		return view('corteDeCaja.buscarMovimientosCaja', compact('dataURL','cuenta'));
	}
}
