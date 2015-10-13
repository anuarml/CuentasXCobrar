<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Menú - Cobranza</title>

		<link rel="icon" type="image/jpg" href="{{ asset('/img/intelisis.jpg') }}" />
		<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/css/simple-sidebar.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">
        <!-- Sidebar -->
	        <div id="sidebar-wrapper">
	            <ul class="sidebar-nav">
	                <li class="sidebar-brand">
	                    <a href="#">
	                        Menú
	                    </a>
	                </li>
	                <li>
	                    <a href="{{ url('cxc/movimiento/nuevo') }}">Cuentas por cobrar</a>
	                </li>
	                <li>
	                    <a href="{{ url('embarques') }}">Embarques</a>
	                </li>
	                <li>
	                    <a href="{{ url('corteCaja') }}">Corte de Caja</a>
	                </li>
	                <li>
	                    <a href="{{ url('/auth/logout') }}">Salir</a>
	                </li>
	            </ul>
	        </div>
	        <!-- /#sidebar-wrapper -->
	        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Presiona aquí</a>
	    </div>

	</body>

	<!-- /#wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</html>