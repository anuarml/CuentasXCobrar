<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Embarque';

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
	/*protected $visible = ['mov', 'mov_id'];

	protected $appends = ['mov', 'mov_id'];

	public function getMovAttribute(){
		return $this->Mov;
	}

	public function getMovIdAttribute(){
		return $this->MovID;
	}*/
}
