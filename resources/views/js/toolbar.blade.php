<script type="text/javascript">var toolbar={movStatus:"{{$mov->status}}",movID:"{{$mov->ID}}",confirmSaveChanges:function(b,d){toolbar.movStatus&&"SINAFECTAR"!=toolbar.movStatus?b():($("#confirmModalBody").html('<img width="25px" src="{{asset("img/save.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;\u00bfGuardar cambios?'),$("#confirmModal").find(".btn-default").click(b),$("#confirmModal").find(".btn-primary").click(function(){toolbar.saveMov(d)}),$("#confirmModal").modal("show"))},confirmCancelMov:function(){$("#confirmModalBody").html('<img width="25px" src="{{asset("img/cancel.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;\u00bfCancelar el movimiento?');$("#confirmModal").find(".btn-primary").click(function(){toolbar.cancelMov()});$("#confirmModal").modal("show")},confirmDeleteMov:function(){$("#confirmModalBody").html('<img width="25px" src="{{asset("img/delete.png")}}">&nbsp;&nbsp;&nbsp;&nbsp;\u00bfEliminar el movimiento?');$("#confirmModal").find(".btn-primary").click(function(){toolbar.deleteMov()});$("#confirmModal").modal("show")},showAlertModal:function(b){$("#alertModalBody").html(b);$("#alertModal").modal("show")},newMov:function(){$("#loading").show();toolbar.redirect("{{ url('cxc/movimiento/nuevo') }}","POST")},saveMov:function(b){toolbar.verifySave()&&(console.log("save"),$("#loading").show(),$("#action").val(b),$("#documentsJson").val(JSON.stringify(aCxcD)),$("#cxcMovForm").submit())},printMov:function(){generateText()},openMov:function(){$("#loading").show();window.location="{{ url('cxc/movimiento/abrir')}}"},deleteMov:function(){toolbar.verifyDelete()&&($("#loading").show(),toolbar.redirect("{{ url('cxc/movimiento/delete') }}","POST"))},affectMov:function(){toolbar.verifyAffect()&&($("#loading").show(),"PENDIENTE"==toolbar.movStatus?window.location="{{ url('cxc/movimiento/affect') }}":toolbar.saveMov("affect"))},cancelMov:function(){toolbar.verifyCancel()&&($("#loading").show(),toolbar.redirect("{{ url('cxc/movimiento/cancel') }}","POST"))},verifySave:function(){var b=!1,d=$("#client_id").val(),c=$("#currency").val(),a=$("#hidden_mov").val();return toolbar.movStatus&&"SINAFECTAR"!=toolbar.movStatus?(toolbar.showAlertModal("Solo se pueden guardar movimientos con estatus 'SINAFECTAR'."),b):d?a?c?!0:(toolbar.showAlertModal("Es necesario seleccionar una moneda."),b):(toolbar.showAlertModal("Es necesario seleccionar un movimiento."),b):(toolbar.showAlertModal("Es necesario seleccionar un cliente."),b)},verifyAffect:function(){var b=!1;return toolbar.movStatus&&"SINAFECTAR"!=toolbar.movStatus&&"PENDIENTE"!=toolbar.movStatus?(toolbar.showAlertModal("Solo se pueden afectar movimientos con estatus 'SINAFECTAR' o 'PENDIENTE'."),b):!0},verifyCancel:function(){var b=!1;return toolbar.movStatus&&"PENDIENTE"!=toolbar.movStatus&&"CONCLUIDO"!=toolbar.movStatus?(toolbar.showAlertModal("Solo se pueden guardar movimientos con estatus 'PENDIENTE' o 'CONCLUIDO'."),b):!0},verifyDelete:function(){var b=!1;return toolbar.movStatus&&"SINAFECTAR"!=toolbar.movStatus?(toolbar.showAlertModal("Solo se pueden guardar movimientos con estatus 'SINAFECTAR'."),b):!0}};$("#newMov").click(function(){toolbar.confirmSaveChanges(toolbar.newMov,"new")});$("#openMov").click(function(){toolbar.confirmSaveChanges(toolbar.openMov,"open")});$("#saveMov").click(function(){toolbar.saveMov("save")});$("#deleteMov").click(toolbar.confirmDeleteMov);$("#affectMov").click(function(){toolbar.affectMov()});$("#cancelMov").click(toolbar.confirmCancelMov);$("#printMov").click(toolbar.printMov);$("#confirmModal").on("hidden.bs.modal",function(b){var d=$(this);b=d.find(".btn-primary");d=d.find(".btn-default");b.html("Si");b.off("click");d.html("No");d.off("click");console.log("hidden")});function generateText(){var b=null;document.getElementById("print");var d=document.createElement("a");d.download="info.txt";d.id="downloadlink";d.style.display="none";var c=new Date,a=c.getDate()+"/"+(c.getMonth()+1)+"/"+c.getFullYear(),c=c.getHours()+":"+c.getMinutes()+":"+c.getSeconds();console.log("{{$mov->MovID}}");for(var a=putSpaces(1,"              "+a+" "+c),a=a+putSpaces(1,"              ASSIS TU VESTIR Matriz"),a=a+putSpaces(1,"              Cobro: {{$mov->MovID}}"),a=a+putSpaces(1,"-----------------------------------------------"),e=aCxcD.length,c=0;c<e;c++)var f=aCxcD[c].apply_id,g=aCxcD[c].amount,a=a+putSpaces(1,aCxcD[c].apply),a=a+putSpaces(2,f),a=a+putSpaces(2,"$"+g+"  ","right");a+=putSpaces(1,"-----------------------------------------------");for(c=1;6>c;c++)$("#amount"+c).val()&&(e="Cobro"+c,f=$("#charge_type"+c).val(),g=$("#amount"+c).val(),a+=putSpaces(1,e),a+=putSpaces(2,f),a+=putSpaces(2,"$"+g+"  ","right"));a+=putSpaces(1,"-----------------------------------------------");c=$("#totalAmount").val();e=$("#change").val();a+=putSpaces(2,"Total:")+putSpaces(2,"$"+c+"  ","right");a+=putSpaces(2,"Cambio:")+putSpaces(2,"$"+e+"  ","right");a+=putSpaces(1,"Leyenda...");a=a+"                                                                                                "+putSpaces(1,"_____________________");a+=putSpaces(1,"Administrador del sistema");a+="                                                                                                ";a=new Blob([a],{type:"text/plain",endings:"native"});null!==b&&window.URL.revokeObjectURL(b);b=window.URL.createObjectURL(a);d.href=b;d.click()}function putSpaces(b,d,c){b=48/b;var a=d.length;if(a>b)d=d.substring(0,b);else for(b-=a,a=0;a<b;a++)d="right"==c?" "+d:d+" ";return d}toolbar.redirect=function(b,d){
@if(count($errors)>0)
return;
@endif
var c=document.createElement("form");d="POST";var a=document.createElement("input");a.type="hidden";a.name="_token";a.value="{{csrf_token()}}";c.appendChild(a);c.method=d;c.action=b;c.submit()};</script>