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
							<a id="affectMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/affect.ico')}}">
							</a>
							
							<a id="affectMov" style="display:inline-block" href="#">
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
									Resuelve los siguientes problemas.<br><br>
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
							<form role="form"> 
							  <div class="form-group" style="text-align:center;">
							    <label class="col-sm-4 control-label" for="saldoInicial">Saldo Inicial:</label>
							    <div class="form-group col-sm-6">
							    	<input type="text" class="form-control" id="saldoInicial" value="$164,558.98" readonly>
							    </div>
							  </div>
							  <div class="form-group" style="text-align:center;">
							    <label class="col-sm-4 control-label" for="deposito">Depósito:</label>
							    <div class="form-group col-sm-6">
							    	<input type="text" class="form-control" id="deposito" value="$100,000.00">
							    </div>
							  </div>
							  <div class="form-group" style="text-align:center;">
								<label class="col-sm-4 control-label" for="cuentaDestino">Cuenta destino</label>
								<div class="form-group col-sm-6">
		        					<select class="form-control" id="cuentaDestino" name="cuentaDestino">
		        						<option selected="true">BMEX5119</option>
		        					</select>
		        				</div>
							  </div>
							  <div class="form-group" style="text-align:center;">
								<label class="col-sm-4 control-label" for="formaPago">Forma de Pago</label>
								<div class="form-group col-sm-6">
		        					<select class="form-control" id="formaPago" name="formaPago">
		        						<option selected="true">Efectivo</option>
		        					</select>
		        				</div>
							  </div>
							  <div class="form-group" style="text-align:center;">
							    <label class="col-sm-4 control-label" for="saldoInicial">Saldo Final:</label>
							    <div class="form-group col-sm-6">
							    	<input type="text" class="form-control" id="saldoInicial" value="$64,000.00" readonly>
							    </div>
							  </div>
							  <div class="form-group" style="text-align:center;">
							  <!--div class="form-group col-sm-12">
							  	<button type="submit" class="btn btn-default" style="a:center;">Afectar?</button>
							  	</div>
							  </div-->
							</form>
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
	<script src="{{ asset('js/bootstrap-table.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table-es-MX.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table-filter-control.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript">
		function moneyFormatter(value){
			var valueFormatted = parseFloat(value) || 0;

			return '$' + moneyFormatForNumbers(valueFormatted);
			//return '$'+valueFormatted.toFixed(2);
		}
		function moneyFormatterRed(value){
			var valueFormatted = parseFloat(value) || 0;
			var style = '';
			if(value==0){
				style = 'color:red';
			}
			return '<span style="'+style+'">$'+ moneyFormatForNumbers(valueFormatted) +'</span>';
		}
		function booleanFormatter(value){
			var icon = '';
			var style = '';
			
			if(value == 1){
				style = 'color:green';
				icon = 'glyphicon glyphicon-ok';
			}
			else if(value == 2) {
				style = 'color:black';
				icon = 'glyphicon glyphicon-stop';
			}
			else {
				style = 'color:red';
				icon = 'glyphicon glyphicon-remove';
			}

			return '<span class="'+icon+'" aria-hidden="true" style="'+style+'"></span>';
		}
		function calculateCashed(){
			var charges = $('#showTable').bootstrapTable('getData');
			var nTotalCharged = 0;
			var nAssignedCharged = 0;
			var nUnassignedCharged = 0;

			if(charges){

				for(var i=0; i<charges.length; i++){

					var charge = charges[i];
					var chargeCashed = parseFloat(charge.cashed) || 0;

					nTotalCharged += chargeCashed;

					if(charge.assigned == 1){
						nAssignedCharged += chargeCashed;
					}
					else{
						nUnassignedCharged += chargeCashed;
					}
				}

				$('#totalCharged').val(moneyFormatForNumbers(nTotalCharged));
				$('#assignedCharged').val(moneyFormatForNumbers(nAssignedCharged));
				$('#unassignedCharged').val(moneyFormatForNumbers(nUnassignedCharged));
			}
		}
		$('#showTable').attr('data-height',$( window ).height() - 90 );

		$('#showTable').bootstrapTable({}).on('load-success.bs.table', function (e, data) {
            calculateCashed();
            /*var charges = $('#showTable').bootstrapTable('getData');
			var nTotalCharged = 0;
			var nAssignedCharged = 0;
			var nUnassignedCharged = 0;

			if(charges){

				for(var i=0; i<charges.length; i++){

					var charge = charges[i];
					var chargeCashed = parseFloat(charge.cashed) || 0;

					nTotalCharged += chargeCashed;

					if(charge.assigned){
						nAssignedCharged += chargeCashed;
					}
					else{
						nUnassignedCharged += chargeCashed;
					}
				}

				$('#totalCharged').val(nTotalCharged.toFixed(2));
				$('#assignedCharged').val(nAssignedCharged.toFixed(2));
				$('#unassignedCharged').val(nUnassignedCharged.toFixed(2));
			}*/
        });

		$('#showTable').bootstrapTable({}).on('search.bs.table', function (e, data) {
            calculateCashed();
        });

		$(window).resize(function () {
            var searchTable = $('#showTable');

            var tableHeight = 400;
	        if( $( window ).height()-80 > tableHeight){
	        	tableHeight = $( window ).height();
	        }

	        //searchTable.attr('data-height',tableHeight);
            searchTable.bootstrapTable('resetView',{'height':tableHeight});
            //searchTable.bootstrapTable('resetWidth');
        });
	</script>

</body>
</html> 