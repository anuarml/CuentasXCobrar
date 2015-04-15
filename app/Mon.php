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
	protected $visible = ['change_type'];

	protected $appends = ['change_type'];

	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}

}
