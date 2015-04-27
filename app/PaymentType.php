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
	protected $visible = ['change_allowed'];

	protected $appends = ['change_allowed'];

	public function getChangeAllowedAttribute(){
		return $this->PermiteCambio;
	}

}
