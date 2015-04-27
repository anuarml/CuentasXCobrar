<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Observacion';

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
	protected $visible = ['observation'];

	protected $appends = ['observation'];

	public function getObservationAttribute(){
		return $this->Observacion;
	}

}
