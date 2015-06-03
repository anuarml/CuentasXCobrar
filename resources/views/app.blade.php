<!DOCTYPE html>
<html lang="en">
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
	<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" href="{{ asset('/css/font-awesome-4.3.0/css/font-awesome.min.css') }}">
	<link href="{{ asset('/css/calculatorStyle.css') }}" rel="stylesheet">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<img id="logoAssis" src="{{ asset('/img/logo_Assi.png') }}" hidden>
				<canvas id="pruebaImagen" hidden></canvas>
				<a class="navbar-brand" href="http://www.assis.mx/">Assis</a>
				<a class="navbar-brand" href="{{ url('/') }}">Cobranza</a>
			</div>

			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::check())
						<li>
							<!--{{url('cxc/movimiento/nuevo')}}-->
							<a id="newMov" style="display:inline-block" href="#">
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
							</a>
							<a id="affectMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/affect.ico')}}">
							</a>
							<a id="cancelMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/cancel.png')}}">
							</a>
							<a style="display:inline-block" href="{{ url('/auth/logout') }}">
								<img height="30px" src="{{asset('img/logout.png')}}">
							</a>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<div class="modal fade" id="confirmModal">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="confirmModalTitle">Cuentas por cobrar</h4>
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
	        <h4 class="modal-title" id="alertModalTitle">Cuentas por cobrar</h4>
	      </div>
	      <div class="modal-body bg-warning" id="alertModalBody">
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
	@include('js.toolbar')
	<script src="{{ asset('/js/cxc/movement/documents.js') }}"></script>
	<script src="{{ asset('/js/bootstrap-table.min.js') }}"></script>
	<script src="{{ asset('/js/cxc/movement/verifications.js') }}"></script>
	@yield('scripts')
</body>
</html>
