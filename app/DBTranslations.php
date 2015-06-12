<?php namespace App;

class DBTranslations {

	public static function getColumnName($name){
		$columnName = null;

		switch($name){
		case 'concept':
			$columnName = 'Concepto';
			break;
		case 'client_id':
		case 'id':
			$columnName = 'Cliente';
			break;
		case 'total_amount':
			$columnName = 'Importe';
			break;
		case 'status':
			$columnName = 'Estatus';
			break;
		case 'emission_date':
			$columnName = 'FechaEmision';
			break;
		case 'name':
			$columnName = 'Nombre';
			break;
		case 'address':
			$columnName = 'Direccion';
			break;
		case 'balance':
			$columnName = 'Saldo';
			break;
		case 'expiration':
		case 'expiration_date':
			$columnName = 'Vencimiento';
			break;
		default:
			$columnName = $name;
			break;
		}

		return $columnName;
	}
}