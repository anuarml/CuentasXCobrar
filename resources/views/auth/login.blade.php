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
								<input type="text" class="form-control" name="username" value="{{ old('username') }}" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">Contraseña</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="company">Empresa</label>
							<div class="col-sm-6">
	        					<select class="form-control" id="company" name="company" required>
	        						<option hidden></option>
	        						@foreach($companies as $company)
	        							<option value="{{ $company->id }}">{{ $company->id }}</option>
	        						@endforeach
	        					</select>
	        				</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label" for="office">Sucursal</label>
							<div class="col-sm-6">
	        					<select class="form-control" id="office" name="office" required>
	        						<option hidden></option>
	        					</select>
	        				</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-5">
								<button type="submit" class="btn btn-primary btn-block">Login</button>
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
	var companies = JSON.parse('{!! $companies->toJson() !!}');

	$('#company').change(updateOfficesList);

	function updateOfficesList(){
		$('#office option').remove();
		$('#office').append('<option hidden></option>');

		for(var i=0;i<companies.length;i++){
			if(companies[i].id == this.value){

				var offices = companies[i].offices;

				for(var j=0;j<offices.length;j++){

					$('#office').append('<option value='+ offices[j].id +'>'+ offices[j].name +'</option>');
				}
				
			}
		}
	}

	var companyVal = $('#company').val('{{ old("company") }}');

	if (companyVal) {
		$('#company').change();
		$('#office').val('{{ old("office") }}');
	};

</script>
@endsection