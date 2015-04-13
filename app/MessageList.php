<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageList extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'MensajeLista';

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
	protected $visible = ['code','description','type'];

	protected $appends = ['code','description','type'];

	public function getCodeAttribute(){
		return $this->Mensaje;
	}

	public function getDescriptionAttribute(){
		return $this->Descripcion;
	}

	public function getTypeAttribute(){
		return $this->Tipo;
	}
}
