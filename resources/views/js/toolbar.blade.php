<script type="text/javascript">

var toolbar = {

	confirmSaveChanges : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/save.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Guardar cambios?');
		$('#confirmModal').find('.btn-primary').click(function(){
			var tempRedirect = window.sessionStorage.getItem('toolbar-temp-redirect');
			window.sessionStorage.setItem('toolbar-redirect',tempRedirect);
			toolbar.saveMov();
		});
		$('#confirmModal').modal('show');
	},

	confirmCancelMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/cancel.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Cancelar el movimiento?');
		$('#confirmModal').find('.btn-primary').click(function(){console.log('cancel');});
		$('#confirmModal').modal('show');
	},

	confirmDeleteMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/delete.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Eliminar el movimiento?');
		$('#confirmModal').find('.btn-primary').click(function(){console.log('delete');});
		$('#confirmModal').modal('show');
	},

	saveMov : function(){
		console.log('save');
		$('#documentsJson').val( JSON.stringify(aCxcD) );
		$('#cxcMovForm').submit();
	},

	checkRedirect: function(){
		var redirect = window.sessionStorage.getItem('toolbar-redirect');

		if(redirect){
			window.sessionStorage.removeItem('toolbar-redirect');
			toolbar.redirect("{{ url('"+redirect+"') }}");
		}
	}
};

$('#newMov').click(function(){
	window.sessionStorage.setItem('toolbar-temp-redirect','cxc/movimiento/nuevo');
	toolbar.confirmSaveChanges();
});
$('#openMov').click(function(){
	//window.sessionStorage.setItem('toolbar-temp-redirect','cxc/movimiento/nuevo');
	toolbar.confirmSaveChanges();
});
$('#saveMov').click(toolbar.saveMov);
$('#deleteMov').click(toolbar.confirmDeleteMov);
$('#cancelMov').click(toolbar.confirmCancelMov);

$('#confirmModal').on('hide.bs.modal', function (event) {
	var modal = $(this);
	modal.find('.btn-primary').off('click');
	console.log('hide');
});

toolbar.redirect = function(url, method) {
    var form = document.createElement('form');
    form.method = method;
    form.action = url;
    form.submit();
};

toolbar.checkRedirect();
</script>