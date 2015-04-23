<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ThoUserAccess extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Empresa';

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
	/*protected $visible = ['id','offices'];

	protected $appends = ['id'];

	public function getIdAttribute(){
		return $this->Empresa;
	}*/

}
