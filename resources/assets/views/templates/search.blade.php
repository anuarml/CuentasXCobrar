<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assis - Cobranza</title>

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
						<div class="panel-heading">Buscar {{ $searchType }}</div>
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
							<div class="col-xs-6 col-xs-offset-0 col-sm-4 col-sm-offset-2">
								<a href="{{ url('/cxc/movimiento/nuevo') }}" class="btn btn-danger btn-block" role="button">Cancelar</a>
							</div>
							<div class="col-xs-6 col-sm-4">
								<button id="selectButton" type="button" class="btn btn-success btn-block">Seleccionar</button>
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
											@yield('table-header')
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

	<div class="modal fade" id="confirmModal">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="confirmModalTitle">Buscar {{ $searchType }}</h4>
	      </div>
	      <div class="modal-body" id="confirmModalBody">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	        <button type="button" class="btn btn-primary">Si</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div class="modal fade" id="alertModal">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="alertModalTitle">Buscar {{ $searchType }}</h4>
	      </div>
	      <div class="modal-body" id="alertModalBody">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Scripts -->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
	<!--<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>-->
	<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-table-es-MX.min.js') }}"></script>
	<script type="text/javascript">
		

		function moneyFormatter(value){
			var valueFormatted = parseFloat(value) || 0;

			return '$'+valueFormatted.toFixed(2);
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