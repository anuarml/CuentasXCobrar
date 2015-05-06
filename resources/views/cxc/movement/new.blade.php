@extends('app')

@section('content')

	<div class="container">
		<form id="cxcMovForm" role="form" action="{{ url('cxc/movimiento/guardar-nuevo') }}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div role="tabpanel">
		
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#datosGenerales" aria-controls="datosGenerales" role="tab" data-toggle="tab">Datos Generales</a></li>
					    <li role="presentation"><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos</a></li>
					    <li role="presentation"><a href="#desgloseCobro" aria-controls="desgloseCobro" role="tab" data-toggle="tab">Desglose Cobro</a></li>
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="datosGenerales">						
							<div class="container-fluid">
								<div class="row">
								    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
										
										<hr class="colorgraph">
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label class="control-label" for="client_id">Cliente:</label>
													<div class='input-group'>
														<span class='input-group-btn'>
															<button type='button' class='btn btn-default' id='searchClient'>
																<span class='glyphicon glyphicon-search'></span>
															</button>
														</span>
														<input type="text" name="client_id" id="client_id" class="form-control" tabindex="1" value="{{isset($mov)?$mov->client_id:''}}" readonly>
													</div>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="ClientName">Nombre Cliente:</label>
													<input type="text" id="ClientName" class="form-control" tabindex="2" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="client_send_to">Sucursal Cliente:</label>
													<div class='input-group'>
														<span class='input-group-btn'>
															<button type='button' class='btn btn-default' id='searchClientOffice'>
																<span class='glyphicon glyphicon-search'></span>
															</button>
														</span>							                        	
														<input type="text" name="client_send_to" id="client_send_to" class="form-control" tabindex="1" readonly>
													</div>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="ClientBalance">Saldo Cliente:</label>
													<div class='input-group'>
														<span class='input-group-btn'>
															<button type='button' class='btn btn-default' id='showClientBalance'>
																<span>...</span>
															</button>
														</span>							                        	
														<input type="text" id="ClientBalance" class="form-control" tabindex="2" readonly>
													</div>
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
													<label for="emission_date">Fecha Emisión:</label>
													<input type="date" name="emission_date" id="emission_date" value="{{isset($mov)?$mov->emission_date->toDateString():Carbon\Carbon::now()->toDateString()}}" class="form-control " tabindex="2" readonly>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="concept">Concepto:</label>
													<select class="form-control" id="concept" name="concept" tabindex="1">
													  <option hidden></option>
													</select>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="reference">Referencia:</label>
													<div class='input-group'>
														<span class='input-group-btn'>
															<button type='button' class='btn btn-default' id='searchMovReference'>
																<span class='glyphicon glyphicon-search'></span>
															</button>
														</span>
							                        	<input type="text" name="reference" id="reference" class="form-control " tabindex="2">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="observations">Observaciones:</label>
													<!--<input type="text" name="Concept" id="Concept" class="form-control " tabindex="2">-->
													<input list="observation-list" name="observations" id="observations" class="form-control" tabindex="3">
													<datalist id="observation-list" >
													  <option value="fosil">
													</datalist>
												</div>
											</div>
											<div class="col-sm-6 ">
												<div class="form-group">
													<label for="currency">Moneda:</label>
													<!--<input type="text" name="Concept" id="Concept" class="form-control " tabindex="2">-->
													<select class="form-control" id="currency" name="currency" tabindex="3">
													  <option hidden></option>
													</select>
												</div>
											</div>
										</div>
										<!--<div class="form-group">
											<label for="Observations">Observaciones:</label>
											<div class='input-group'>
												<span class='input-group-btn'>
													<button type='button' class='btn btn-default' id='searchMovObservations'>
														<span class='glyphicon glyphicon-search'></span>
													</button>
												</span>
					                        	<input type="text" name="Observations" id="Observations" class="form-control" tabindex="3">
											</div>
											<input list="Observations" name="browser" id="inpObservations" class="form-control" tabindex="3">
											<datalist id="Observations" >
											  <option value="Internet Explorer">
											</datalist>
										</div>-->
									</div>
								</div>
							</div>
					    </div>

					    <div role="tabpanel" class="tab-pane" id="documentos">
					    	<br>
					    	<button type="button" id="newDocumentRow" class='btnz btn-primary'>Agregar <span class="glyphicon glyphicon-plus"></span></button>
					    	<input type="hidden" id="documentsJson" name="documentsJson">
					    	<hr>
							<div class = "table-responsive">
								<table id="documentsTable" class="table table-bordered">
							        <thead>
							            <tr>
							                <th>Aplica</th>
							                <th>Consecutivo</th>
							                <th>Importe</th>
							                <th>Diferencia</th>
							                <th>Diferencia(%)</th>
							                <th>Concepto</th>
							                <th>Referencia</th>
							                <th hidden>Descuento</th>
							                <th hidden>Sugerencia</th>
							                <th></th>
							            </tr>
							        </thead>
							        <tbody>
							        	
							        </tbody>
							    </table>
						    </div>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="desgloseCobro">
					    	<div class="container-fluid">
					    	<br>
					    	<button type="button" id="newChargeRow" class='btnz btn-primary'>Agregar <span class="glyphicon glyphicon-plus"></span></button>
					    	<hr class="colorgraph">
					    	<div id="charges" class="container-fluid"></div>
					    	<hr class="colorgraph">
				    		<div class='form-group'>
				    			<div class='col-sm-3'>
				    				<label for="pro_balance">Saldo a Favor</label>
				    				<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
				    					<input type='number' class='form-control input-sm' name='pro_balance' id='pro_balance' min='0' step='any'>
				    				</div>
				    			</div>
				    			<div class='col-sm-3'>
				    				<label for="change">Cambio</label>
				    				<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
				    					<input type='number' class='form-control input-sm' name='change' id='change' min='0' step='any'>
				    				</div>
				    			</div>
				    			<div class='col-sm-2'>
				    				<label for="totalCharge">Cobro Total</label>
				    				<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
				    					<input type='number' class='form-control input-sm' id='totalCharge' min='0' step='any' readonly>
				    				</div>
				    			</div>
				    			<div class='col-sm-2'>
				    				<label for="totalAmount">Importe Total</label>
				    				<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
				    					<input type='number' class='form-control input-sm' id='totalAmount' min='0' step='any' readonly>
				    				</div>
				    			</div>
				    			<div class='col-sm-2'>
				    				<label for="difference">Por Cobrar</label>
				    				<div class='input-group'>
				    					<div class='input-group-addon'>$</div>
				    					<input type='number' class='form-control input-sm' id='difference' min='0' step='any' readonly>
				    				</div>
				    			</div>
				    		</div>
				    		</div>
					    </div>
					  </div> 
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/cxc/movement/documents.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cxc/movement/new.js') }}"></script>
@endsection