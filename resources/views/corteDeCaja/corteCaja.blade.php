<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Corte de Caja</title>

	<link rel="icon" type="image/jpg" href="{{ asset('/img/money.jpg') }}" />
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<!--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->
	<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
        function preloader(){
            document.getElementById("loading").style.display = "none";
            //document.getElementById("content").style.display = "block";
        }
        window.onload = preloader;
	</script>
</head>
<body>
	<div id="loading"></div>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<canvas id="pruebaImagen" hidden></canvas>
				<a class="navbar-brand" href="http://www.assis.mx/">Assis</a>
				<a class="navbar-brand" href="{{ url('/') }}">Cobranza</a>
			</div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::check())
						<li>
							<!--{{url('cxc/movimiento/nuevo')}}-->
							<!--a id="newMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/new.png')}}">
							</a>
							<a id="openMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/open.png')}}">
							</a>
							<a id="saveMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/save.png')}}">
							</a>
							<a id="deleteMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/delete.png')}}">
							</a>
							<a id="printMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/print.png')}}">
							</a-->
							<a id="afectar" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/affect.ico')}}">
							</a>
							
							<a id="reporteCorteCaja" style="display:inline-block" href="{{ url('corteCaja/reporteCaja') }}">
								<img height="30px" src="{{asset('img/reporteCorteCaja.ico')}}">
							</a>
							<!--a id="cancelMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/cancel.png')}}">
							</a-->
							<a style="display:inline-block" href="{{ url('/auth/logout') }}">
								<img height="30px" src="{{asset('img/logout.png')}}">
							</a>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading">Corte de caja</div>
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							<!--<div class="col-xs-6 col-xs-offset-3">
								<a href="{{ url('/') }}" class="btn btn-primary btn-block" role="button">Regresar</a>
							</div>
							<br><br-->
							@if ( \Session::has('mensaje') )
								<div class="alert alert-{{ \Session::get('mensaje')->tipo }} alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									{!! \Session::get('mensaje')->mensaje !!}
								</div>
							@endif
							{!! Form::model($din,['id'=>'CorteCajaForm']) !!}
							  
							  <div class="form-group">
							    <label class="col-sm-offset-1 col-sm-3 control-label" for="saldo">Saldo Inicial:</label>
							    <div class="form-group col-sm-7">
								    <div class='input-group'>
										<span class='input-group-addon'>$</span>
										<input type="text" class="form-control" id="saldo" name="saldo" value="" disabled>
									</div>
								</div>
							  </div>

							  <div class="form-group">
							    <label class="col-sm-offset-1 col-sm-3 control-label" for="Importe">Depósito:</label>
							    <div class="form-group col-sm-7">
							    	<div class='input-group'>
										<span class='input-group-addon'>$</span>
										<input type="text" class="form-control" id="Importe" value="" tabindex="1" autofocus>
									</div>
							    </div>
							  </div>
							  
							  <div class="form-group">
								<!--label class="col-sm-offset-1 col-sm-3 control-label" for="cuentaDestino">Cuenta destino</label-->
								{!! Form::label('CtaDineroDestino', 'Cuenta Destino', array('class'=>'col-sm-offset-1 col-sm-3 control-label')) !!}
								<div class="form-group col-sm-7">
		        					<!--select class="form-control" id="cuentaDestino" name="cuentaDestino" tabindex="2">
		        						<option selected="true"></option>
		        					</select-->
		        					{!! Form::select('CtaDineroDestino', [], null, array('class'=>'form-control','tabindex'=>'2')) !!}
		        				</div>
							  </div>
							  
							  <div class="form-group">
								<!--label class="col-sm-offset-1 col-sm-3 control-label" for="formaPago">Forma de Pago</label-->
								{!! Form::label('FormaPago', 'Forma de Pago', array('class'=>'col-sm-offset-1 col-sm-3 control-label')) !!}
								<div class="form-group col-sm-7">
		        					<!--select class="form-control" id="formaPago" name="formaPago" tabindex="3">
		        						<option selected="true">Efectivo</option>
		        					</select-->
		        					{!! Form::select('FormaPago', [], null, array('class'=>'form-control','tabindex'=>'3')) !!}
		        				</div>
							  </div>
							  
							  <div class="form-group">
							    <label class="col-sm-offset-1 col-sm-3 control-label" for="saldoFinal">Saldo Final:</label>
							    <div class="form-group col-sm-7">
							    	<div class='input-group'>
										<span class='input-group-addon'>$</span>
										<input type="text" class="form-control" id="saldoFinal" name="saldoFinal" value="" disabled>
									</div>
							    </div>
							  </div>
							  <!--<div class="form-group">
							  <div class="form-group col-sm-12">
							  	<button type="submit" class="btn btn-default" style="a:center;">Afectar?</button>
							  	</div>
							  </div-->
							  {!! Form::hidden('ID',null,['id'=>'ID']) !!}
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Scripts -->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
	<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript">
		var saldo = parseFloat('{{ $saldo }}') || 0;

		$('#saldo').val(moneyFormatForNumbers(saldo));


		$('#afectar').click(function(){

			$('#CorteCajaForm').submit();
		});

		var paymentTypeList = JSON.parse('{!! $paymentTypeList !!}');

		var paymentTypeOptions = '';

		for(var i=1; i < paymentTypeList.length; i++){
			var paymentType = paymentTypeList[i];
			paymentTypeOptions += '<option value="'+paymentType.payment_type+'">'+paymentType.payment_type+'</option>';
		}

		$('#FormaPago').append(paymentTypeOptions);

		var destinyAccountList = JSON.parse('{!! $destinyAccountList !!}');
		var destinyAccountOptions = '';

		console.log(destinyAccountList);

		for(var i=1; i < destinyAccountList.length; i++){
			var destinyAccount = destinyAccountList[i];
			destinyAccountOptions += '<option value="'+destinyAccount.CtaDinero+'">'+destinyAccount.CtaDinero+'</option>';
		}

		//console.log(destinyAccountOptions);
		$('#CtaDineroDestino').append(destinyAccountOptions);
		
		//console.log(paymentTypeList);
		//console.log(options);
		

	</script>

</body>
</html> 