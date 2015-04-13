<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cxc extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Cxc';

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
	protected $hidden = [];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = ['ID', 'Empresa','Mov'];

	public function details(){
		return $this->hasMany('App\CxcD','ID','ID');
	}

}
