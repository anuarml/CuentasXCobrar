<?php namespace App\Http\Controllers\CorteCaja;

use App\CorteCaja\Dinero;
use App\CorteCaja\DineroSaldo;
use App\PaymentType;
use App\Http\Controllers\Controller;
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

		$paymentTypeList = [];//PaymentType::Web()->select('FormaPago')->get()->toArray();

		$din = new Dinero;

		
		return view('corteDeCaja.corteCaja', compact('din','saldo','paymentTypeList'));
	}

	public function postGuardar(){

		$dineroID = \Input::get('ID');
		
		$dinero = Dinero::findOrNew($dineroID);

		if($dinero->status && $dinero->status != 'SINAFECTAR'){
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
		$nowDate = Carbon::now()->format('d/m/Y');

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

		$dinero->save();


		$action = \Input::get('action');

		switch ($action) {
			case 'afectar':
				afectar($dinero->ID);
				//return redirect('corteCaja/afectar');
				break;	 
			default:
				$message = new \stdClass();
				$message->type = 'INFO';
				$message->description = 'Movimiento guardado.';
				$message->code = $cxc->ID;
				$message->reference = '';
				return redirect('corteCaja')
						->withMessage($message);
				break;
		}
	}

	public function getAfectar($ID){

		//$ID = \Input::get('ID');

		$user = \Auth::user();

		//$din = Dinero::findOrFail($ID);
		$din = Dinero::findOrNew($ID, Dinero::$COLUMN_NAMES);

		$resultado = $din->afectar($user->username);
		$mensaje = $din->crearMensaje($resultado);

		return redirect('corteCaja')
				->withMensaje($mensaje)
				->with('DineroID',$ID);
	}


}
