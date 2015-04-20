@extends('app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div role="tabpanel">
	
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#DatosGenerales" aria-controls="DatosGenerales" role="tab" data-toggle="tab">Datos Generales</a></li>
				    <li role="presentation"><a href="#Documentos" aria-controls="Documentos" role="tab" data-toggle="tab">Documentos</a></li>
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
											<label id="Observationss" for="Observations">Observaciones:</label>
											<input type="text" name="Observations" id="Observations" class="form-control " tabindex="3">
										</div>
											
									</form>
								</div>
							</div>
						</div>
				    </div>

				    <div role="tabpanel" class="tab-pane" id="Documentos">
				    	<br>
				    	<button id="newDocumentRow" class='btn btn-lg btn-primary addnewrow'>Agregar <span class="glyphicon glyphicon-plus"></span></button>
				    	<hr>
				    	<!--<button type="button" class="btn btn-primary">Agregar +</button>-->
				    	<!--<table id="documentsTable" data-url="data1.json" data-height="299" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" >
				    	<table id="documentsTable" data-url="data1.json" data-height="299">
						    <thead>
						    <tr>
						        <th data-field="consecutive" data-align="center">Consecutivo</th>
						        <th data-field="amount" data-align="center">Importe</th>
						        <th data-field="difference" data-align="center">Diferencia</th>
						        <th data-field="differencePercentage" data-align="center" >Diferencia(%)</th>
						        <th data-field="concept" data-align="center" >Concepto</th>
						        <th data-field="reference" data-align="center">Referencia</th>
						        <th data-field="delete"></th>
						    </tr>
						    </thead>
						</table>-->
						<table id="documentsTable"  data-url="documentos" data-cache="false" data-height="299" data-show-refresh="true">
						<!--<table id="documentsTable">-->
						    <thead>
						        <tr>
						            <th data-field="consecutive" data-align="center">Consecutivo</th>
							        <th data-field="amount" data-align="center">Importe</th>
							        <th data-field="difference" data-align="center">Diferencia</th>
							        <th data-field="differencePercentage" data-align="center" >Diferencia(%)</th>
							        <th data-field="concept" data-align="center" >Concepto</th>
							        <th data-field="reference" data-align="center">Referencia</th>
							        <th data-field="delete" data-align="center"></th>
						        </tr>
						    </thead>
						</table>
				    </div>
				    <div role="tabpanel" class="tab-pane" id="DesgloseCobro">

				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
<script type="text/javascript" src="js/nuevoMovimiento.js"></script>
@endsection