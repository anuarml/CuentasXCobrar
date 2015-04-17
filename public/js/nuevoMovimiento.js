/*$('#myTab a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})*/ 
/*$('.selectpicker').selectpicker();

 $('.selectpicker').selectpicker({
      style: 'btn-info',
      size: 4
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




/*$('#item20').click(function(){
	alert('se pudo');
});*/

/*function deleteRow(){
	alert('hola');
}*/

/*$("#idtabla").bootstrapTable().onLoadSuccess(function(){
	alert('gg');
	$(".deleterow").click(deleteRow);
});*/


/*var prueba = $('#Observationss');
prueba.click(function(){
	alert('se pudo');
});*/

//console.log($(".deleterow"));

/*$(".deleterow").on("click", function(){
var $killrow = $(this).parent('tr');
    $killrow.addClass("danger");
	$killrow.fadeOut(1000, function(){
    $(this).remove();
});});*/


/*$(".addnewrow").on("click", function(){
	$('table tr:last').after("<tr data-index='21'><td><span>NEW</span></td><td><span>NEW</span></td><td><span>NEW</span></td><td><span>NEW</span></td><td><span>NEW</span></td><td><span>NEW</span></td><td><span>NEW</span></td><div class='deleterow'><div class='glyphicon glyphicon-remove'></div></div><tr>");});*/