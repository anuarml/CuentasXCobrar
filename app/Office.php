<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model {

	protected $primaryKey = 'Sucursal';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Sucursal';

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
	protected $visible = ['id','name', 'company'];

	/**
	 * The attributes included with get*Attribute() method.
	 *
	 * @var array
	 */
	protected $appends = ['id','name'];

	public function getIdAttribute(){
		return $this->Sucursal;
	}

	public function getNameAttribute(){
		return $this->Nombre;
	}

	public function company(){
		return $this->belongsTo('App\Company','Empresa','Empresa');
	}

}
