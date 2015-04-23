<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assis - Cobranza</title>

	<link rel="icon" type="image/jpg" href="{{ asset('/img/money.jpg') }}" />

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

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
				<a class="navbar-brand" href="#">Assis</a>
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
							<a style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/save.png')}}">
							</a>
							<a id="deleteMov" style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/delete.png')}}">
							</a>
							<a style="display:inline-block" href="#">
								<img height="30px" src="{{asset('img/print.png')}}">
							</a>
							<a style="display:inline-block" href="#">
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

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('js/toolbar.js') }}"></script>
	@yield('scripts')
</body>
</html>