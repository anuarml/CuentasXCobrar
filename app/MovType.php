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
	protected $visible = ['Mov','Factor'];

	protected $appends = [];

	public static function getMovTypeList(){

		$movTypeList = [null => ''];

		$movTypes = self::where('ThoCxcWeb',true)->orderBy('Mov')->get();

		foreach ($movTypes as $movType) {
			$movTypeList[$movType->Mov] = $movType->Mov;
		}

		return $movTypeList;
	}
}
