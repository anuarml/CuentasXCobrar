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
		clientBalanceInput.val( clientBalanceAmount.toFixed(2) );
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