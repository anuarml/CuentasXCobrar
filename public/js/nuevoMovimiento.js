/*var refresh = false;

$("#documentsTable").bootstrapTable().on('load-success.bs.table', function (e, data) {
	console.log(refresh);
	if(!refresh){
		$('#documentsTable').bootstrapTable('refresh');
		refresh = true;
	}
	
	$(".deleterow").on("click", function(){
	var $killrow = $(this).parent('td').parent('tr');
	    $killrow.addClass("danger");
		$killrow.fadeOut(1000, function(){
	    $(this).remove();
	});});
});

$(".addnewrow").on("click", function(){
	$('#documentsTable tr:last').after("<tr><td style='text-align: center;'>100</td><td style='text-align: center;'>NEW</td><td style='text-align: center;'>NEW</td><td style='text-align: center;'>NEW</td><td style='text-align: center;'>NEW</td><td style='text-align: center;'>NEW</td><td style='text-align: center;'><div class='deleterows'><div class='glyphicon glyphicon-remove'></div></div></td><tr>");
	$(".deleterows").on("click", function(){
		var $killrow = $(this).parent('td').parent('tr');
		    $killrow.addClass("danger");
			$killrow.fadeOut(1000, function(){
		    $(this).remove();
	});});}
);*/

/*$(function () {
    documents= [ {
        "Consecutivo":"v4_294",
        "Importe":"6-18-2014 22:51:59",
        "Diferencia":"hi@h.com",
        "Diferencia(%)":"xxxx",
        "Concepto":2895,
        "Referencia": "wololo",
        "Delete": "<div class = 'deleterow'><div class='glyphicon glyphicon-remove'></div></div>"
    }];

    function createdocumentsTable(documents){
        documentsTable = $('#documentsTable').bootstrapTable({
            data : documents,
            striped : true,  
            height : 400,
            columns : [ {
                field : 'Consecutivo',
                title : 'Consecutivo',
                align : 'middle',
                valign : 'middle',
                sortable : false
            }, {
                field : 'Importe',
                title : 'Importe',
                align : 'middle',
                valign : 'middle',
                sortable : false
            }, {
                field : 'Diferencia',
                title : 'Diferencia',
                align : 'middle',
                valign : 'middle',
                sortable : false
            }, {
            	field : 'Diferencia(%)',
                title : 'Diferencia(%)',
                align : 'middle',
                valign : 'middle',
                sortable : false
            }, {
            	field : 'Concepto',
                title : 'Concepto',
                align : 'middle',
                valign : 'middle',
                sortable : false
            }, {
            	field : 'Referencia',
                title : 'Referencia',
                align : 'middle',
                valign : 'middle',
                sortable : false
            }, {
            	field : 'Delete',
                title : 'Delete',
                align : 'middle',
                valign : 'middle',
                sortable : false
            } ]
        });
    }
    createdocumentsTable(documents);
});*/

/*$("#documentsTable").bootstrapTable().on('load-success.bs.table', function (e, data) {	
	$(".deleterow").on("click", function(){
	var $killrow = $(this).parent('td').parent('tr');
	    $killrow.addClass("danger");
		$killrow.fadeOut(1000, function(){
	    $(this).remove();
	});});
});*/
/*var documents = [];
var numberOfDocuments = 0;
function document(apply, consecutive, amount, difference, differencePercentage, concept, reference){
	this.apply;
	this.consecutive;
	this.amount;
	this.difference;
	this.differencePercentage;
	this.concept;
	this.reference;
}*/

$(".addnewrow").on("click", function(){
	
	$('#documentsTable tbody').append("<tr><td style='text-align: center;' class='apply'></td><td style='text-align: center;' class='consecutive'></td><td style='text-align: center;' class='amount'></td><td style='text-align: center;' class='difference' ></td><td style='text-align: center;' class='differencePercentage'></td><td style='text-align: center;' class='concept'></td><td style='text-align: center;' class='reference'></td><td style='text-align: center;'><div class='deleterows'><div class='glyphicon glyphicon-remove'></div></div></td><td style='text-align: center;'><div class='editrow'><div class='glyphicon glyphicon-pencil'></div></div></td><td style='text-align: center;'><div class = 'calculator' align= 'center'><div class='fa fa-calculator'></div></div></td></tr>");
	
	$("#documentsTable tbody tr:last .deleterows").on("click", function(){
		var $killrow = $(this).parent('td').parent('tr');
		    $killrow.addClass("danger");
			$killrow.fadeOut(1000, function(){
		    	$(this).remove();
			});
	});

	$("#documentsTable tbody tr:last .apply").on("click", function(e){
		$(e.target).append("<select class='form-control' id='apply'><option>a</option><option>b</option></select> ");
		$("#apply").focus();
	});

	$("#documentsTable tbody tr:last .apply").on("focusout", function(e){
		console.log($(this) + "gorgojo");
		$("#apply option:selected").text();
		$(this).empty();
	});

	$("#documentsTable tbody tr:last .consecutive").on("click", function(e){
		/*$(e.target).append("<select class='form-control' id='apply'><option></option></select> ");
		$("#apply").focus();*/
		window.location("/cxc/documento/buscar")
	});

	

	/*$(".apply").on("click", function(e){
		//$(this).remove();
		//console.log($(this));
		$(e.target).append("<input type='text' id='txtApply'>")
		//$("#txtApply").focus();
	})*/

	/*$(".apply").on("focusout", function(e){
		//e.preventDefault();
		console.log($(this) + "gorgojo");
		$(this).empty();
	})*/

	;}
);
/*<select class='form-control'><option>Parangaricutirimicuaro</option></select>*/