<?php namespace App\CorteCaja;

use Illuminate\Database\Eloquent\Model;
use App\EmpresaConcepto;

class Dinero extends Model {

	protected $primaryKey = 'ID';

    public $timestamps = false;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'Dinero';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'CtaDineroDestino',
		'Importe',
		'FormaPago',
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
        'ID' => 'integer',
	    'Importe' => 'float',
        'TipoCambio' => 'integer',
	];

	/**
	 * The attributes included from the model's JSON form.
	 *
	 * @var array
	 */
	protected $visible = [
		'ID',
		'Empresa',
		'Mov',
		'MovID',
		'FechaEmision',
		'UltimoCambio',
		'Concepto',
		'Moneda',
		'TipoCambio',
		'Referencia',
		'Usuario',
		'Estatus',
		'Directo',
		'CtaDinero',
		'CtaDineroDestino',
		'Importe',
		'FormaPago',
		'Sucursal',
		'FechaRegistro'
	];

    const MODULO_TESORERIA = 'DIN';

    static $COLUMN_NAMES = [
        'ID',
        'Empresa',
        'Mov',
        'MovID',
        'FechaEmision',
        'UltimoCambio',
        'Concepto',
        'Moneda',
        'TipoCambio',
        'Referencia',
        'Usuario',
        'Estatus',
        'Directo',
        'CtaDinero',
        'ConDesglose',
        'CtaDineroDestino',
        'TipoCambioDestino',
        'Importe',
        'FormaPago',
        'Sucursal',
        'SucursalOrigen',
        'Prioridad',
        'FechaRegistro',
        'FechaProgramada',
        'TasaDias'
    ];

	/**
     * Obtiene el modelo de la cuenta de dinero asociada al movimiento.
     */
    public function ctaDin()
    {
        return $this->hasOne('App\CorteCaja\CtaDinero','CtaDinero','CtaDinero')->select(['Tipo','Moneda']);
    }

    /**
     * Obtiene el modelo de la cuenta de dinero destino asociada al movimiento.
     */
    public function ctaDinDestino()
    {
        return $this->hasOne('App\CorteCaja\CtaDinero','CtaDinero','CtaDineroDestino')->select(['Tipo','Moneda']);
    }

    /**
     * Obtiene el modelo de la forma de pago asociada al movimiento.
     */
    public function formaPago()
    {
        return $this->hasOne('App\PaymentType','FormaPago','FormaPago');
    }

    /**
     * Obtiene el modelo de la Moneda asociada al movimiento.
     */
    public function mon()
    {
        return $this->hasOne('App\Mon','Moneda','Moneda')->select(['Moneda','TipoCambio']);
    }

    /*
     * Obtiene el tipo de cuenta destino.
     */
    public function getTipoCtaDinDestinoAttribute(){

    	$tipoCtaDinero = null;
    	$ctaDinDestino = $this->ctaDinDestino;

    	if($ctaDinDestino){
    		$tipoCtaDinero = $ctaDinDestino->Tipo;
    	}

    	return $tipoCtaDinero;
    }

    /*
     * Obtiene el tipo de movimiento (Mov) que se va a
     * generar dependiendo del tipo de cuenta destino.
     */
    public function getTipoMovimientoAttribute(){

    	$tipoMovimiento = null;
    	$tipoCtaDinDestino = strtolower($this->tipo_cta_din_destino);

    	/*if(!$tipoCtaDinDestino){
    		return null;
    	}

    	if($tipoCtaDinDestino == CtaDinero::TIPO_CAJA){
    		$tipoMovimiento = config('cortecaja.mov_corte_en_caja');
    	}
    	else if($tipoCtaDinDestino == CtaDinero::TIPO_BANCO){
    		$tipoMovimiento = config('cortecaja.mov_corte_en_banco');
    	}*/

    	if($tipoCtaDinDestino){
    		$tipoMovimiento = config('cortecaja.mov_corte_en_'.$tipoCtaDinDestino);
    	}

    	return $tipoMovimiento;
    }

    /*
     * Obtiene el concepto por omisión del movimiento
     * dependiendo del tipo de la empresa(Empresa) y movimiento(Mov).
     */
    public function getConceptoOmisionAttribute(){

    	/*$concepto = null;
    	$mov = strtolower($this->Mov);
    	$mov = str_replace(' ', '_', $mov);

    	if($mov){
    		$concepto = config('cortecaja.concepto_'.$mov);
    	}

    	return $concepto;*/

        $concepto = null;
        $empresa = $this->Empresa;
        $modulo = self::MODULO_TESORERIA;
        $mov = $this->Mov;

        $empresaConcepto = EmpresaConcepto::findByPk($empresa, $modulo, $mov, ['Concepto']);
        
        if($empresaConcepto){
            $concepto = $empresaConcepto->Concepto;
        }

        return $concepto;
    }

    /*
     * Obtiene el modelo de la moneda de la cuenta destino.
     */
    public function getMonedaCtaDinDestinoAttribute(){

    	$moneda = null;
    	$ctaDinDestino = $this->ctaDinDestino;

    	if($ctaDinDestino){
    		$moneda = $ctaDinDestino->mon;
    	}

    	return $moneda;
    }

    /*
     * Obtiene el tipo de cambio de la moneda.
     */
    public function getTipoCambioMonAttribute(){

        $tipoCambio = null;
        $moneda = $this->mon;

        if($moneda){
            $tipoCambio = $moneda->TipoCambio;
        }

        return $tipoCambio;
    }

    /*
     * Obtiene el tipo de cambio de la cuenta destino.
     */
    public function getTipoCambioCtaDestinoAttribute(){

        $tipoCambio = null;
        $moneda = $this->moneda_cta_din_destino;

        if($moneda){
            $tipoCambio = $moneda->TipoCambio;
        }

        return $tipoCambio;
    }

    /*
     * Afecta el movimiento.
     * @return array
     *      [0] Código de mensaje
     *      [1] Descripción del mensaje
     *      [2] Tipo de mensaje ( AUTORIZACION, CFG, ERROR, INFO, INFORMACION, PRECAUCION )
     *      [3] Referencia
     */
    public function afectar($usuario, $accion = 'Afectar'){

        $modulo = self::MODULO_TESORERIA;
        $movID = $this->ID;
        $result = [];
        
        if( !$usuario ){
            $result[] = ['','Se requiere un usuario para '.$accion.'.','ERROR',''];
            return $result;
        }

        /* 
         * Cambia el modo de obtener el resultado, debido a que el sp devuelve columnas sin nomnbres. 
         * Se obtiene un array con el número de columna como índices.
         */
        \DB::connection()->setFetchMode(\PDO::FETCH_NUM);

        $consulta = 'EXECUTE spAfectar ?, ?, ?, NULL, NULL, ?, 1, 0';
        $parametros = [
            $modulo,
            $movID,
            $accion,
            $usuario
        ];

        // Ejecuta el spAfectar y obtiene el resultado.
        $result = \DB::select( $consulta, $parametros);

        \DB::connection()->setFetchMode(\PDO::FETCH_CLASS);

        return $result[0];
    }

    /*
     * Crea un mensaje para mostrar en la vista con el resultado del spAfectar.
     */
    public function crearMensaje(array $parametros){

        $codigo     = $parametros[0];
        $descripcion= $parametros[1];
        $tipo       = $parametros[2]; // [2] Tipo de mensaje ( AUTORIZACION, CFG, ERROR, INFO, INFORMACION, PRECAUCION )
        $referencia = $parametros[3];

        $mov   = $this->Mov;
        $movID = $this->MovID;

        $mensaje = new \stdClass();
        
        if($codigo == null){
            $mensaje->tipo = 'success';
            $mensaje->mensaje = $mov.' '.$movID.' afectado.';
        }
        else{
            switch ($tipo) {
                case 'INFO':
                case 'INFORMACION':
                    $mensaje->tipo = 'info';
                    break;
                case 'PRECAUCION':
                    $mensaje->tipo = 'warning';
                    break;
                case 'AUTORIZACION':
                case 'ERROR':
                case 'CFG':
                    $mensaje->tipo = 'danger';
                    break;
                default:
                    $mensaje->tipo = 'info';
                    break;
            }
            
            $mensaje->mensaje = '';

            if($codigo){
                $mensaje->mensaje .= '('.$codigo.') ';
            }
            if($descripcion){
                $mensaje->mensaje .= $descripcion;
            }
            if($referencia){
                $mensaje->mensaje .= '<BR>'.$referencia;
            }
            if($movID){
                $mensaje->mensaje .= '<BR>'.$mov.' '.$movID;
            }
        }

        return $mensaje;
    }

    public static function obtenerReporteCaja(){
        $modulo = self::MODULO_TESORERIA;
        $empresa = 'ASSIS';//$this->Empresa;
        $moneda = config('cxc.default_currency');
        $caja = 'CJAGE01';
        $fechaInicio = '01/10/2015';
        $fechaFinal = '31/10/2015';
        $nivel = 'Movimiento';
        $vista = 'Normal';
        $grupo = 0;
        $totalizar = 1;
        $gpo = '';

        $result = [];

        /* 
         * Cambia el modo de obtener el resultado, debido a que el sp devuelve columnas sin nomnbres. 
         * Se obtiene un array con el número de columna como índices.
         */
        //\DB::connection()->setFetchMode(\PDO::FETCH_NUM);

        $consulta = "SET NOCOUNT ON; EXEC spVerAuxiliar ?, @@SPID, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
        $parametros = [
            $empresa,
            $modulo,
            $moneda,
            $gpo,
            $caja,
            $fechaInicio,
            $fechaFinal,
            $nivel,
            $vista,
            $grupo,
            $totalizar
        ];

        // Ejecuta el spAfectar y obtiene el resultado.
        $result = \DB::select( $consulta, $parametros);

        //\DB::connection()->setFetchMode(\PDO::FETCH_CLASS);

        return $result;
    }
}
