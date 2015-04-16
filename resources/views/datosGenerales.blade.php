@extends('app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div role="tabpanel">
	
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#DatosGenerales" aria-controls="DatosGenerales" role="tab" data-toggle="tab">Datos Generales</a></li>
				    <li role="presentation"><a href="#DesgloseCobro" aria-controls="DesgloseCobro" role="tab" data-toggle="tab">Desglose Cobro</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="DatosGenerales">						
						<div class="container-fluid">
							<div class="row">
							    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
									<form role="form">
										<hr class="colorgraph">
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="Client">Cliente:</label>
							                        <input type="text" name="Client" id="Client" class="form-control"tabindex="1">
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="ClientName">Nombre Cliente:</label>
													<input type="text" name="ClientName" id="ClientName" class="form-control" tabindex="2">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="ClientOffice">Sucursal Cliente:</label>
							                        <input type="text" name="ClientOffice" id="ClientOffice" class="form-control"tabindex="1">
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="ClientBalance">Saldo Cliente:</label>
													<input type="text" name="ClientBalance" id="ClientBalance" class="form-control " tabindex="2">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="Mov">Movimiento:</label>
							                        <select class="form-control" id="Mov" name="Mov" tabindex="1">
													  <option hidden></option>
													  <option>Anticipo</option>
													  <option>Cobro</option>
													</select>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="EmissionDate">Fecha Emisión:</label>
													<input type="text" name="EmissionDate" id="EmissionDate" class="form-control " tabindex="2">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="Concept">Concepto:</label>
													<input type="text" name="Concept" id="Concept" class="form-control " tabindex="2">
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="Reference">Referencia:</label>
													<input type="text" name="Reference" id="Reference" class="form-control " tabindex="2">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="Observations">Observaciones:</label>
											<input type="text" name="Observations" id="Observations" class="form-control " tabindex="3">
										</div>
											
									</form>
								</div>
							</div>
						</div>
				    </div>
				    <div role="tabpanel" class="tab-pane" id="DesgloseCobro">

				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	


<script type="text/javascript" src="js/datosGenerales.js"></script>
@endsection
