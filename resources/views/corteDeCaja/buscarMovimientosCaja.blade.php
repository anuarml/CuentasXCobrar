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
						<div class="panel-heading">Reporte Cuenta Dinero</div>
						<div class="panel-body" style="padding-bottom:0">
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
							</div>
							<div class="clearfix"></div>

							<div class="row">
								<table id="searchTable" data-toggle="table" 
								data-url="{{ url($dataURL) }}" 
								data-search="true" 
								data-show-columns="true" 
								data-click-to-select="true" 
								data-pagination="true"
								data-side-pagination="server"
								data-page-list="[]"
								data-page-size="100"
								data-height="400">
									<thead>
										<tr>
										    <th data-field="Fecha" data-align="center" data-sortable="true">Fecha</th>
										    <th data-field="Mov" data-align="center" data-sortable="true">Movimiento</th>
										    <th data-field="Referencia" data-align="center" data-sortable="true">Referencia</th>
										    <th data-field="Cargo" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Cargos</th>
										    <th data-field="Abono" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Abonos</th>
										    <th data-field="Total" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Saldos</th>
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
		

		function moneyFormatter(value){
			var valueFormatted = parseFloat(value) || 0;

			//return '$'+valueFormatted.toFixed(2);*/

			return '$'+moneyFormatForNumbers(valueFormatted);
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