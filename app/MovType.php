<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MovType extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'MovTipo';

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
	protected $visible = ['mov'];

	protected $appends = ['mov'];

	public function getMovAttribute(){
		return $this->Mov;
	}

}
