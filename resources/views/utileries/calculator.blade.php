<!DOCTYPE html>
<html lang="es">
	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Calculadora</title>

		<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
		<link href="{{ asset('/css/calculatorStyle.css') }}" rel="stylesheet">

	</head>

	<body>
		<div id="calculator">
            <!-- Screen and clear key -->
            <div class="top">
                <span class="clear">C</span>
                <div class="screen"></div>
            </div>
            
            <div class="keys">
                <!-- operators and other keys -->
                <span>7</span>
                <span>8</span>
                <span>9</span>
                <span class="operator">+</span>
                <span>4</span>
                <span>5</span>
                <span>6</span>
                <span class="operator">-</span>
                <span>1</span>
                <span>2</span>
                <span>3</span>
                <span class="operator">/</span>
                <span>0</span>
                <span>.</span>
                <span>%</span>
                <span class="operator">*</span>
                <span class="eval">=</span>
            </div>
        </div>

        
        <!-- Scripts -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script src="{{ asset('js/decimal.min.js') }}"></script>
		@include('js/utileries/calculator')
		
	</body>

</html>