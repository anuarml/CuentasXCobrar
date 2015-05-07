var toolbar = {

	confirmSaveChanges : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/save.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Guardar cambios?');
		$('#confirmModal').find('.btn-primary').click(toolbar.saveMov);
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
	}
};

$('#newMov').click(toolbar.confirmSaveChanges);
$('#openMov').click(toolbar.confirmSaveChanges);
$('#deleteMov').click(toolbar.confirmDeleteMov);
$('#cancelMov').click(toolbar.confirmCancelMov);

$('#confirmModal').on('hide.bs.modal', function (event) {
	var modal = $(this);
	modal.find('.btn-primary').off('click');
	console.log('hide');
});
