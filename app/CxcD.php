<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CxcD extends Model {

	public $timestamps = false;
	protected $primaryKey = 'Renglon';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'CxcD';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['office','row','apply', 'apply_id', 'amount', 'p_p_discount'];

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
	protected $visible = ['office','ID','row','apply', 'apply_id', 'amount', 'p_p_discount','origin'];
	
	protected $appends = ['office','row','apply', 'apply_id', 'amount', 'p_p_discount'];

	public function getOfficeAttribute(){
		return $this->Sucursal;
	}
	public function setOfficeAttribute($office){
		return $this->Sucursal = $office;
	}

	public function getRowAttribute(){
		return $this->Renglon;
	}
	public function setRowAttribute($row){
		return $this->Renglon = $row;
	}

	public function getApplyAttribute(){
		return $this->Aplica;
	}
	public function setApplyAttribute($apply){
		return $this->Aplica = $apply;
	}


	public function getApplyIdAttribute(){
		return $this->AplicaID;
	}
	public function setApplyIdAttribute($applyID){
		return $this->AplicaID = $applyID;
	}


	public function getAmountAttribute(){
		return $this->Importe;
	}
	public function setAmountAttribute($amount){
		return $this->Importe = $amount;
	}


	public function getPPDiscountAttribute(){
		return $this->DescuentoRecargos;
	}
	public function setPPDiscountAttribute($ppDiscount){
		return $this->DescuentoRecargos = $ppDiscount;
	}


	public function cxc(){
		return $this->belongsTo('App\Cxc','ID','ID');
	}



	public function updateRow(){
		\DB::table($this->getTable())
			->where('ID', $this->ID)
			->where('Renglon', $this->row)
			->update([
				'Importe' => $this->amount,
				'AplicaID' => $this->apply_id,
			]);
	}


	public function suggestPP(){

		$company = \Auth::user()->getSelectedCompany();

		$cxc = $this->cxc;

		$client = $cxc->client_id;
		$emissionDate = $cxc->emission_date_str;
		$mov = $cxc->Mov;
		$apply = $this->apply;
		$consecutive = $this->apply_id;

		//dd([$company,$client,$emissionDate,$mov,$apply,$consecutive]);

		$suggestPP = 0;

		$stmt = \DB::getPdo()->prepare('EXEC spThoDescPPWeb ?, ?, ?, ?, ?, ?, ?');
		
		$stmt->bindParam(1, $company);
		$stmt->bindParam(2, $client);
		$stmt->bindParam(3, $emissionDate);
		$stmt->bindParam(4, $mov);
		$stmt->bindParam(5, $apply);
		$stmt->bindParam(6, $consecutive);
		$stmt->bindParam(7, $suggestPP, \PDO::PARAM_STR | \PDO::PARAM_INPUT_OUTPUT, 5);

		$stmt->execute();

		return $suggestPP;
	}
}

