<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tabla Embarque</title>

	<link rel="icon" type="image/jpg" href="{{ asset('/img/money.jpg') }}" />
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<!--<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>-->
	<link href="{{ asset('/css/bootstrap-table.min.css') }}" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-heading">Embarque</div>
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
							<div class="row">
								<table id="showTable" data-toggle="table" data-url="{{ url($dataURL) }}" data-search="true" data-show-columns="true" data-show-refresh="true">
									<thead>
										<tr>
											<th data-field="client" data-align="center" data-sortable="true">Cliente</th>
										    <th data-field="mov" data-align="center" data-sortable="true">Mov</th>
										    <th data-field="movID" data-align="center" data-sortable="true">MovID</th>
										    <th data-field="balance" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Saldo</th>
										    <th data-field="cashed" data-align="center" data-sortable="true" data-formatter="moneyFormatter">Cobrado</th>
										    <th data-field="assigned" data-align="center" data-sortable="true" data-formatter="booleanFormatter">Asignado</th>
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

	<!-- Scripts -->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
	<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
	<script type="text/javascript">
		function moneyFormatter(value){
			var valueFormatted = parseFloat(value) || 0;

			return '$'+valueFormatted.toFixed(2);
		}
		function booleanFormatter(value){
			var icon = '';
			
			if(value == true){
				style = 'color:green';
				icon = 'glyphicon glyphicon-ok';
			}
			else {
				style = 'color:red';
				icon = 'glyphicon glyphicon-remove';
			}

			return '<span class="'+icon+'" aria-hidden="true" style="'+style+'"></span>';
		}
		
		$('#showTable').attr('data-height',$( window ).height() - 90 );
	</script>

</body>
</html>