<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcBalance extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcSaldo';

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
	protected $visible = ['balance'];

	protected $appends = ['balance'];

	public function getBalanceAttribute(){
		return $this->Saldo;
	}
}
