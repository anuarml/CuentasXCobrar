<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'FormaPago';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = [];


	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['payment_type','change_allowed'];

	protected $appends = ['payment_type','change_allowed'];

	public function getPaymentTypeAttribute(){
		return $this->FormaPago;
	}

	public function getChangeAllowedAttribute(){
		return $this->PermiteCambio;
	}

	public static function getPaymentTypeList(){

		$paymentTypeList = [['payment_type'=> '','change_allowed'=>0]];

		$paymentTypes = self::where('CXCWEB', true)->get();

		foreach ($paymentTypes as $paymentType) {
			$paymentTypeList[] = $paymentType;
			//$paymentTypeList[$paymentType->payment_type] = $paymentType;
		}

		return json_encode($paymentTypeList);
	}

	public static function getPaymentTypeChangeAllowed(){

		$paymentTypeList = [];

		$paymentTypes = self::where('CXCWEB', true)->get();

		foreach ($paymentTypes as $paymentType) {
			//$paymentTypeList[] = $paymentType;
			$paymentTypeList[$paymentType->payment_type] = $paymentType->change_allowed;
		}

		return json_encode($paymentTypeList);
	}

}
