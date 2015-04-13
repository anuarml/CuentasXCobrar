@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
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

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-sm-4 control-label">Usuario</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="username" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Contraseña</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="slt_company">Empresa</label>
							<div class="col-sm-6">
	        					<select class="form-control" id="slt_company">
	        						<option hidden></option>
	        						@foreach($companies as $company)
	        							<option>{{ $company->id }}</option>
	        						@endforeach
	        					</select>
	        				</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="slt_office">Sucursal</label>
							<div class="col-sm-6">
	        					<select class="form-control" id="slt_office">
	        						<option hidden></option>
	        					</select>
	        				</div>
						</div>

						<div class="form-group">
							<div class="col-sm-6 col-sm-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-6 col-sm-offset-4">
								<button type="submit" class="btn btn-primary">Login</button>

								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	var companies = JSON.parse('{!!$companies->toJson()!!}');

	$('#slt_company').change(updateOfficesList);

	function updateOfficesList(){
		$('#slt_office option').remove();
		$('#slt_office').append('<option hidden></option>');

		for(var i=0;i<companies.length;i++){
			if(companies[i].id == this.value){

				var offices = companies[i].offices;

				for(var j=0;j<offices.length;j++){

					$('#slt_office').append('<option value='+ offices[j].id +'>'+ offices[j].name +'</option>');
				}
				
			}
		}
	}

</script>
@endsection