<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mon extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Mon';

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
	protected $visible = ['change_type', 'currency'];

	protected $appends = ['change_type','currency'];

	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}

	public function getCurrencyAttribute(){
		return trim($this->Moneda);
	}

	public static function getCurrencyList(){

		$currencyList = [null => ''];

		$currencys = self::orderby('Orden')->get();

		foreach ($currencys as $currency) {
			$currencyList[$currency->currency] = $currency->currency;
		}

		return $currencyList;
	}

}
