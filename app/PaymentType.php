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

		$paymentTypeList = [null => ''];

		$paymentTypes = self::where('CXCWEB', true)->get();

		foreach ($paymentTypes as $paymentType) {
			$paymentTypeList[$paymentType->payment_type] = $paymentType->payment_type;
		}

		return $paymentTypeList;
	}

}
