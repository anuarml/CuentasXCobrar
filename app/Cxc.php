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
	protected $visible = ['office_id', 'origin_office_id'];

	protected $appends = ['id'];

	public function getOfficeIdAttribute(){
		return $this->Sucursal;
	}

	public function getOriginOfficeIdAttribute(){
		return $this->SucursalOrigen;
	}

	public function getClientIdAttribute(){
		return $this->Cliente;
	}

	public function getClientSendToAttribute(){
		return $this->ClienteEnviarA;
	}

	public function getCompanyeAttribute(){
		return $this->Empresa;
	}

	public function getMoveAttribute(){
		return $this->Mov;
	}

	public function getEmissionDateAttribute(){
		return $this->FechaEmision;
	}

	public function getAmountAttribute(){
		return $this->Importe;
	}

	public function getTaxesAttribute(){
		return $this->Impuestos;
	}

	public function getCurrencyAttribute(){
		return $this->Moneda;
	}

	public function getChangeTypeAttribute(){
		return $this->TipoCambio;
	}

	public function getClientCurrencyTypeAttribute(){
		return $this->ClienteMoneda;
	}

	public function getClientChangeTypeAttribute(){
		return $this->ClienteTipoCambio;
	}

	public function getUserAttribute(){
		return $this->Usuario;
	}

	public function getStatusAttribute(){
		return $this->Estatus;
	}

	public function getCtaDineroAttribute(){
		return $this->CtaDinero;
	}

	public function getCashierAttribute(){
		return $this->Cajero;
	}

	public function getUenAttribute(){
		return $this->UEN;
	}

	public function getProjectAttribute(){
		return $this->Proyecto;
	}

	public function getOriginTypeAttribute(){
		return $this->OrigenTipo;
	}

	public function getOfficeAttribute(){
		return $this->Origen;
	}

	public function getOfficeAttribute(){
		return $this->OrigenID;
	}

	public function getOfficeAttribute(){
		return $this->AplicaManual;
	}

	public function getOfficeAttribute(){
		return $this->Referencia;
	}

	public function getOfficeAttribute(){
		return $this->Concepto;
	}

	public function getOfficeAttribute(){
		return $this->Condicion;
	}

	public function getOfficeAttribute(){
		return $this->Observaciones;
	}

	public function getOfficeAttribute(){
		return $this->ContUso;
	}

	public function getOfficeAttribute(){
		return $this->ConDesglose;
	}

	public function getOfficeAttribute(){
		return $this->FormaCobro1;
	}

	public function getOfficeAttribute(){
		return $this->FormaCobro2;
	}

	public function getOfficeAttribute(){
		return $this->FormaCobro3;
	}

	public function getOfficeAttribute(){
		return $this->FormaCobro4;
	}

	public function getOfficeAttribute(){
		return $this->FormaCobro5;
	}

	public function getOfficeAttribute(){
		return $this->Importe1;
	}

	public function getOfficeAttribute(){
		return $this->Importe2;
	}

	public function getOfficeAttribute(){
		return $this->Importe3;
	}

	public function getOfficeAttribute(){
		return $this->Importe4;
	}

	public function getOfficeAttribute(){
		return $this->Importe5;
	}

	public function getOfficeAttribute(){
		return $this->Referencia1;
	}

	public function getOfficeAttribute(){
		return $this->Referencia2;
	}

	public function getOfficeAttribute(){
		return $this->Referencia3;
	}

	public function getOfficeAttribute(){
		return $this->Referencia4;
	}

	public function getOfficeAttribute(){
		return $this->Referencia5;
	}

	public function getOfficeAttribute(){
		return $this->Cambio;
	}

	public function getOfficeAttribute(){
		return $this->DelEfectivo;
	}

	public function getOfficeAttribute(){
		return $this->ThoAsignadoWeb;
	}

	public function details(){
		return $this->hasMany('App\CxcD','ID','ID');
	}

}
