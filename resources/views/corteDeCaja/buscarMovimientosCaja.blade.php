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
	<link href="{{ asset('/css/bootstrap-table.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/calculatorStyle.css') }}" rel="stylesheet">
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
	<style type="text/css">
		.pagination-detail{
			display: none;
		}
	</style>
</head>
<body>
	<div id="loading"></div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="panel panel-default" style="margin-bottom:0;">
						<div class="panel-heading">Reporte Cuenta Dinero ({{ $cuenta }})</div>
						<div class="panel-body" style="padding-bottom:0">
							<div class="row">
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
								<div class="col-xs-6 col-xs-offset-3">
									<a href="{{ url('corteCaja') }}" class="btn btn-primary btn-block" role="button">Regresar</a>
									<br>
								</div>
								<div class="clearfix"></div>
								<div class="col-sm-12">
									<form class="form-horizontal">
										<div class="row">

											<div class="col-xs-6 col-sm-6 col-md-6" >
												<div class="form-group">
													<label class="col-xs-4 col-sm-3 col-md-4 control-label" for="saldo">Fecha Inicial: </label>
													<div class="col-xs-8 col-sm-9 col-md-8">
														<div class="row">
															<input type="text" class="form-control" name="FechaInicio" id="FechaInicio" onblur="this.type='text'" onfocus="this.type='date'" style="border:1px solid #ccc; border-radius:6px;">
														</div>
													</div>
												</div>
											</div>

											<div class="col-xs-6 col-sm-6 col-md-6" >
												<div class="form-group">
													<label class="col-xs-4 col-sm-3 col-md-4 control-label" for="saldo">Fecha  Final: </label>
													<div class="col-xs-8 col-sm-9 col-md-8">
														<div class="row">
															<input type="text" class="form-control" name="FechaFin" id="FechaFin" onblur="this.type='text'" onfocus="this.type='date'" style="border:1px solid #ccc; border-radius:6px;">
														</div>
													</div>
												</div>
											</div>

										</div>
									</form>
								</div>

								<!--div class="clearfix"></div-->

								<div class="col-xs-4 col-xs-offset-4 col-sm-2 col-sm-offset-5 " >
									<button class="btn btn-info btn-block" id="filtrarFechas">Filtrar</button>
								</div>
								<table id="searchTable" data-toggle="table" 
								data-url="{{ url($dataURL) }}" 
								data-show-columns="true" 
								data-pagination="true"
								data-side-pagination="server"
								data-page-list="[]"
								data-page-size="100"
								data-height="400">
									<thead>
										<tr>
										    <th data-field="Fecha" data-align="center" data-sortable="false" data-formatter="dateFormatter">Fecha</th>
										    <th data-field="Mov" data-align="center" data-sortable="false">Movimiento</th>
										    <th data-field="Referencia" data-align="center" data-sortable="false">Referencia</th>
										    <th data-field="Cargo" data-align="center" data-sortable="false" data-formatter="moneyFormatter">Cargos</th>
										    <th data-field="Abono" data-align="center" data-sortable="false" data-formatter="moneyFormatter">Abonos</th>
										    <th data-field="Total" data-align="center" data-sortable="false" data-formatter="moneyFormatter">Saldos</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@yield('action')

	<!-- Scripts -->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->

	<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table-es-MX.min.js') }}"></script>
	<script src="{{ asset('js/app.js') }}"></script>
	<script type="text/javascript">
		

		$('#filtrarFechas').click(function(){
			var fehcaInicio = $('#FechaInicio').val();
			var fehcaFin = $('#FechaFin').val();
			$('#searchTable').bootstrapTable('refresh', {query: {fechaFin: fehcaFin, fechaInicio: fehcaInicio}});
		});
		
		function moneyFormatter(value,row,index){
			var valueFormatted = parseFloat(value) || null;

			if(valueFormatted == null){
				return null;
			}

			valueFormatted = '$'+moneyFormatForNumbers(valueFormatted);
			var data = $('#searchTable').bootstrapTable('getData', true);
			
			if(data.length == index + 1){
				valueFormatted = '<strong>'+valueFormatted+'</strong>';
			}

			return valueFormatted;
		}
		
		function dateFormatter(value,row,index){
			var data = $('#searchTable').bootstrapTable('getData', true);
			var formatedValue;
			
			if(data.length != index + 1){
				formatedValue = value;
			}
			else{
				formatedValue = '<strong>Total</strong>';
			}

			return formatedValue;
		}


		$.extend($.fn.bootstrapTable.defaults, $.fn.bootstrapTable.locales['es-MX']);
		$(window).resize(function () {
            var searchTable = $('#searchTable');

            var tableHeight = 400;
	        if( $( window ).height()-80 > tableHeight){
	        	tableHeight = $( window ).height();
	        }

	        //searchTable.attr('data-height',tableHeight);
            searchTable.bootstrapTable('resetView',{'height':tableHeight});
            //searchTable.bootstrapTable('resetWidth');
        });

        var searchTable = $('#searchTable');

		searchTable.attr('data-height',$(window).height());


	</script>
	@yield('scripts')
</body>
</html>