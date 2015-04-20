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

$("#documentsTable").bootstrapTable().on('load-success.bs.table', function (e, data) {	
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
);