@extends('app')

@section('content')
	<div class="container">
		<div class="row">
			{!! Form::model( $mov, array('url' => array('cxc/movimiento/guardar'), 'id'=>'cxcMovForm','autocomplete'=>'off' ) ) !!}
				{!! Form::hidden('action', null, array('id'=>'action' )) !!}
				{!! Form::hidden('clickedRow', null, array('id'=>'clickedRow' )) !!}
				<div class="col-xs-12 col-xs-offset-0 col-md-10 col-md-offset-1">
					@if (count($errors) > 0)
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Resuelve los siguientes problemas.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					@if ( \Session::has('message') )
						@if( \Session::get('message')->type == 'ERROR' )
							<div class="alert alert-danger alert-dismissible">
						@elseif(\Session::get('message')->type == 'INFO')
							<div class="alert alert-success alert-dismissible">
						@else
							<div class="alert alert-warning alert-dismissible">
						@endif
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							{{ \Session::get('message')->type }}
							{{ '('.\Session::get('message')->code.')' }}
							{!! \Session::get('message')->description !!}<br>
							<p>{!! \Session::get('message')->reference !!}</p>
						</div>
					@endif
					<div role="tabpanel">
						<div class="row">
						  <!-- Nav tabs -->
						  <ul class="nav nav-tabs" role="tablist">
						    <li role="presentation" class="active"><a href="#datosGenerales" aria-controls="datosGenerales" role="tab" data-toggle="tab">Datos Generales</a></li>
						    <li role="presentation"><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab" id="tabDocs">Documentos</a></li>
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
														{!! Form::label('client_id', 'Cliente:') !!}
														<div class='input-group'>
															<span class='input-group-btn'>
																<button type='button' class='btn btn-default' id='searchClient'>
																	<span class='glyphicon glyphicon-search'></span>
																</button>
															</span>
															{!! Form::text('client_id', null, array('class'=>'form-control', 'readonly'=>'true')) !!}
														</div>
													</div>
												</div>
												<div class="col-sm-6 ">
													<div class="form-group">
														{!! Form::label('client[name]', 'Nombre Cliente:') !!}
														{!! Form::text('client[name]', null, array('class'=>'form-control', 'readonly'=>'true')) !!}
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6 ">
													<div class="form-group">
														{!! Form::label('Mov', 'Movimiento:') !!}
														{!! Form::select('Mov', $movTypeList, null, array('class'=>'form-control')) !!}
														{!! Form::hidden('Mov', null, array('id'=>'hidden_mov')) !!}
													</div>
												</div>

												<div class="col-sm-6 ">
													<div class="form-group">
														{!! Form::label('emission_date_str', 'Fecha Emisión:') !!}
														{!! Form::date('emission_date_str', null, array('type'=>'date', 'class'=>'form-control', 'readonly'=>'true')) !!}
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-sm-6 ">
													<div class="form-group">
														{!! Form::label('client_send_to', 'Sucursal Cliente:') !!}
														<div class='input-group'>
															<span class='input-group-btn'>
																<button type='button' class='btn btn-default' id='searchClientOffice'>
																	<span class='glyphicon glyphicon-search'></span>
																</button>
															</span>
															{!! Form::text('client_send_to', null, array('class'=>'form-control', 'readonly'=>'true')) !!}
														</div>
													</div>
												</div>
												<div class="col-sm-6 ">
													<div class="form-group">
														{!! Form::label('clientBalance', 'Saldo Cliente:') !!}
														<div class='input-group'>
															<span class='input-group-addon'>
																$
															</span>
															{!! Form::text('clientBalance', null, array('class'=>'form-control', 'readonly'=>'true')) !!}
															<span class='input-group-btn'>
																<button type='button' class='btn btn-default' id='showClientBalance'>
																	<span>...</span>
																</button>
															</span>
														</div>
													</div>
												</div>
											</div>
											
											<div class="row">
												<div class="col-sm-6 ">
													<div class="form-group">
														<!--<label for="concept">Concepto:</label>-->
														{!! Form::label('concept', 'Concepto:') !!}
														<!--<select class="form-control" id="concept" name="concept" tabindex="1">
														  <option hidden></option>
														</select>-->
														@if($mov->status == 'SINAFECTAR' || $mov->status == '')
															{!! Form::select('concept', array(null => ''), null, array('class'=>'form-control')) !!}
														@else
															{!! Form::select('concept', array(null => ''), null, array('class'=>'form-control', 'disabled'=>'true')) !!}
														@endif
													</div>
												</div>
												<div class="col-sm-6 ">
													<div class="form-group">
														<!--<label for="reference">Referencia:</label>-->
														{!! Form::label('reference', 'Referencia:') !!}
														<div class='input-group'>
															<span class='input-group-btn'>
																<button type='button' class='btn btn-default' id='searchMovReference'>
																	<span class='glyphicon glyphicon-search'></span>
																</button>
															</span>
								                        	<!--<input type="text" name="reference" id="reference" class="form-control " tabindex="2">-->
								                        	@if($mov->status == 'SINAFECTAR' || $mov->status == '')
																{!! Form::text('reference', null, array('class'=>'form-control')) !!}
															@else
																{!! Form::text('reference', null, array('class'=>'form-control', 'readOnly'=>'true')) !!}
															@endif							          
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-6 ">
													<div class="form-group">
														<!--<label for="observations">Observaciones:</label>-->
														{!! Form::label('observations', 'Observaciones:') !!}
														<!--<input type="text" name="Concept" id="Concept" class="form-control " tabindex="2">-->
														<!--<input list="observation-list" name="observations" id="observations" class="form-control" tabindex="3">-->
														@if($mov->status == 'SINAFECTAR' || $mov->status == '')
															{!! Form::text('observations', null, array('list'=>'observation-list','class'=>'form-control')) !!}
														@else
															{!! Form::text('observations', null, array('list'=>'observation-list','class'=>'form-control', 'disabled'=>'true')) !!}
														@endif
														<datalist id="observation-list">
														  <option value="fosil">
														</datalist>
													</div>
												</div>
												<div class="col-sm-6 ">
													<div class="form-group">
														<!--<label for="currency">Moneda:</label>-->
														{!! Form::label('currency', 'Moneda:') !!}
														<!--<input type="text" name="Concept" id="Concept" class="form-control " tabindex="2">-->
														<!--<select class="form-control" id="currency" name="currency" tabindex="3">
														  <option hidden></option>
														</select>-->
														@if($mov->status == 'SINAFECTAR' || $mov->status == '')
															{!! Form::select('currency',$currencyList, 'Pesos', array('class'=>'form-control')) !!}
														@else
															{!! Form::select('currency',$currencyList, 'Pesos', array('class'=>'form-control', 'disabled'=>'true')) !!}
														@endif

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						    </div>

						    <div role="tabpanel" class="tab-pane" id="documentos">
						    	<br>
						    	@if($mov->status == 'SINAFECTAR' || $mov->status == '')
									<button type="button" id="newDocumentRow" class='btn btn-primary' >Agregar <span class="glyphicon glyphicon-plus"></span></button>
								@endif
						    	<!--<button type="button" id="newDocumentRow" class='btnz btn-primary'>Agregar <span class="glyphicon glyphicon-plus"></span></button>-->
						    	<input type="hidden" id="documentsJson" name="documentsJson">
						    	<hr>
								<div class = "table-responsive">
									<!--<table id="documentsTable" class="table table-bordered">-->
									<table id="documentsTable" data-unique-id="id" data-toggle="table" data-show-columns="true" data-height="400" data-show-toggle="true">
								        <thead>
								            <tr>
								                <th data-field="id" data-visible="false" data-switchable="false">ID</th>
								                <th data-field="apply">Aplica</th>
								                <th data-field="apply_id">Folio</th>
								                <th data-field="amount" data-formatter="moneyFormatter">Importe</th>
								                <th data-field="difference" data-formatter="moneyFormatter" data-visible="false">Diferencia</th>
								                <th data-field="difference_percent" data-visible="false">%</th>
								                <th data-field="concept" data-visible="true">Concepto</th>
								                <th data-field="reference" data-visible="false">Referencia</th>
								                <th data-field="pp_discount" data-formatter="moneyFormatter" data-visible="false" class="discountPPPHeader">Descuento</th>
								                <th data-field="pp_suggest" data-formatter="moneyFormatter" data-visible="false" class="suggestPPPHeader">Sugerencia</th>
								                <th data-field="actions" data-visible="false" data-switchable="false" data-events="actionEvents"></th>
								            </tr>
								        </thead>
								        <tbody class="noselect">
								        </tbody>
								    </table>
							    </div>
						    </div>
						    <div role="tabpanel" class="tab-pane" id="desgloseCobro">
						    	<div class="container-fluid">
						    	<br>
						    	@if($mov->status == 'SINAFECTAR' || $mov->status == '')
									<button type="button" id="newChargeRow" class='btn btn-primary'>Agregar <span class="glyphicon glyphicon-plus"></span></button>
								@endif
						    	<!--<button type="button" id="newChargeRow" class='btnz btn-primary'>Agregar <span class="glyphicon glyphicon-plus"></span></button>-->
						    	<hr class="colorgraph">
						    	<div id="charges" class="container-fluid">
						    		
						    	</div>
						    	<hr class="colorgraph">
					    		<div class='form-group'>
				    				<div class='col-sm-3' id='dvProBalance'>
					    				<!--<label for="pro_balance">Saldo a Favor</label>-->
					    				{!! Form::label('pro_balance','Saldo a Favor') !!}
					    				<div class='input-group'>
					    					<div class='input-group-addon'>$</div>
					    					<!--<input type='number' class='form-control input-sm' name='pro_balance' id='pro_balance' min='0' step='any'>-->
					    					@if($mov->status == 'SINAFECTAR' || $mov->status == '')
												{!! Form::text('pro_balance', null, array('class'=>'form-control input-sm', 'value'=>'0.00' )) !!}
											@else
												{!! Form::text('pro_balance', null, array('class'=>'form-control input-sm', 'readOnly'=>'true', 'value'=>'0.00')) !!}
											@endif
					    					
					    				</div>
					    			</div>
					    			<div class='col-sm-3'>
					    				<label for="change">Cambio</label>
					    				
					    				<div class='input-group'>
					    					<div class='input-group-addon'>$</div>
					    					
					    					@if($mov->status == 'SINAFECTAR' || $mov->status == '')
												
												<input type='text' class='form-control input-sm' name='change' id='change' >
											@else
												
												<input type='text' class='form-control input-sm' name='change' id='change'  readonly>
											@endif
					    					
					    				</div>
					    			</div>
					    			<div class='col-sm-2' id='dvTotalCharge'>
					    				<label for="totalCharge">Importe Total</label>
					    				<div class='input-group'>
					    					<div class='input-group-addon'>$</div>
					    					<input type='text' class='form-control input-sm' id='totalCharge' readonly>
					    				</div>
					    			</div>
					    			<div class='col-sm-2' id='dvTotalAmount'>
					    				<label for="totalAmount">Total</label>
					    				<div class='input-group'>
					    					<div class='input-group-addon'>$</div>
					    					<input type='text' class='form-control input-sm' id='totalAmount' value="0.00" readonly>
					    					<input type="hidden" name="amount" id="amount">
					    					<input type="hidden" name="taxes" id="taxes">
					    				</div>
					    			</div>
					    			<div class='col-sm-2' id='dvDifference'>
					    				<label for="difference">Por Cobrar</label>
					    				<div class='input-group'>
					    					<div class='input-group-addon'>$</div>
					    					<input type='text' class='form-control input-sm' id='difference' readonly>
					    				</div>
					    			</div>
					    			<div class='col-sm-2' id='dvTotalChangeAllowed' hidden>
					    				<label for="totalChangeAllowed">Cambio Permitido</label>
					    				<div class='input-group'>
					    					<div class='input-group-addon'>$</div>
					    					<input type='text' class='form-control input-sm' id='totalChangeAllowed' min='0' step='any' value='{{$totalChangeAllowedAmount}}' readonly>
					    				</div>
					    			</div>	
					    		</div>
					    		</div>
						    </div>
						  </div> 
						</div>
					</div>
				</div>
			<!--</form>-->
			{!! Form::close() !!}
		</div>
	</div>
@endsection

@section('scripts')
@include('utileries/calculator')
<script src="{{ asset('js/decimal.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cxc/movement/documents.js') }}"></script>
<!--<script src="{{ asset('/js/cxc/movement/verifications.js') }}"></script>-->
@include('js/utileries/calculator')
@include('js/cxc/movement/new')
<script type="text/javascript" src="{{ asset('js/cxc/movement/breakdownCharge.js') }}"></script>
<script type="text/javascript">
	var mov = $('#Mov');
	var concept = '{{$mov->concept}}';

	$(mov.prop('firstElementChild')).attr('hidden','true');
	$($('#concept').prop('firstElementChild')).attr('hidden','true');

	mov.change(function(){

		$.ajax( { url: '{{url("cxc/movimiento/concept-list")}}/' + $(this).val()  } ).done(function( conceptList ){

			var conceptSelect = $('#concept');
			conceptSelect.empty();

			var conceptListLen = conceptList.length;
			for(var i=0; i < conceptListLen; i++){
				
				conceptSelect.append('<option value="'+ conceptList[i].Concepto +'">'+ conceptList[i].Concepto +'</option>');
			}

			conceptSelect.val(concept);
		});
	});

	if(mov.val()){
		mov.change();
	}

	$('#change').val( new Number($('#change').val()).toFixed(2) );
	$('#pro_balance').val( new Number($('#pro_balance').val()).toFixed(2) );

	var clientBalanceInput = $('#clientBalance');
	var clientBalance =  JSON.parse('{!!$clientBalance!!}');
	var clientBalanceAmount = 0;
	
	if(clientBalance != ''){

		if(clientBalance != null){
			clientBalanceAmount = parseFloat(clientBalance.balance) || 0;
		}
		clientBalanceInput.val(moneyFormatForNumbers(clientBalanceAmount));
	}
	

	function showMovDetails(){
		var movDetails = JSON.parse('{!! $mov->details->toJson() !!}');
		for(var i = 0; i < movDetails.length; i++){

			var movDetail = movDetails[i];
			
			var cxcD = new CxcD(movDetail);
			var cxcDocument = new CxcDocument(movDetail.origin);
			//console.log(cxcD.row);
			addDocumentRow(cxcD, cxcDocument);
		}
	}

	paymentTypeList = JSON.parse('{!! $paymentTypeList !!}');
	paymentTypeListChangeAllowed = JSON.parse('{!! $paymentTypeListChangeAllowed !!}');

	function showChargeDetails(){
		var movCharges = JSON.parse('{!!$movCharges!!}');
		if(movCharges){
			for(var i = 0; i < movCharges.length; i++){
				var charge = new Charge(movCharges[i]);
				//console.log(charge.payment_type);
				if(parseInt(charge.amount) != 0)
				addChargeRow(charge);
			}
		}
	}

	$(window).load(function(){
		showMovDetails();
	});
//	showMovDetails();

	showChargeDetails();
	function getApplyOptions(clientID){
		$.ajax( { url: '{{url("cxc/movimiento/apply-list")}}/' + clientID } ).done(function( data ){

			var applyList = data;

			for(var i=0; i < applyList.length; i++){
				applyOptions += '<option value="'+applyList[i]+'">'+applyList[i]+'</option>';
			}
		});
	};

	var clientID = $('#client_id').val();

	if( clientID ) {
		getApplyOptions(clientID);
	}

	$(window).resize(function () {
        var documentsTable = $('#documentsTable');

        documentsTable.bootstrapTable('resetWidth');
    });

    //$('#documentsTable').bootstrapTable('resetView',{'height':$(window).height()-20});

</script>

@endsection

