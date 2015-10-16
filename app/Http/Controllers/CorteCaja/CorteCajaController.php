<?php namespace App\Http\Controllers\CorteCaja;

use App\CorteCaja\Dinero;
use App\CorteCaja\DineroSaldo;
use App\PaymentType;
use App\CorteCaja\CtaDinero;
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

		$paymentTypeList = PaymentType::getPaymentTypeList();//PaymentType::Web()->select('FormaPago')->get()->toArray();
		$destinyAccountList = CtaDinero::getDestinyAccountList();

		$din = new Dinero;

		return view('corteDeCaja.corteCaja', compact('saldo','paymentTypeList','destinyAccountList'));
	}

	public function getMovimientosCaja(){

	}

	public static function showMovimientosCaja(){
		
		$dataURL = 'corteCaja/movimientosCaja';
		
		return view('corteDeCaja.buscarMovimientosCaja', compact('dataURL'));
	}
}
