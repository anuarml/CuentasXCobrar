<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyCfg extends Model {

	class Company extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'EmpresaCfg';

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
	protected $visible = ['cxc_auto_adjust_mov'];

	protected $appends = ['cxc_auto_adjust_mov'];
	
	public function getCxcAutoAdjustMovAttribute(){
		return $this->CxcAutoAjusteMov;
	}

}
