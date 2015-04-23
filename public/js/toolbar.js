var toolbar = {

	confirmSaveChanges : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/save.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Guardar cambios?');
		$('#confirmModal').modal('show');
	},

	confirmCancelMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/cancel.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Cancelar el movimiento?');
		$('#confirmModal').modal('show');
	},

	confirmDeleteMov : function(){

		$('#confirmModalBody').html('<img width="25px" src="/img/delete.png">&nbsp;&nbsp;&nbsp;&nbsp;¿Eliminar el movimiento?');
		$('#confirmModal').modal('show');
	}
};

$('#newMov').click(toolbar.confirmSaveChanges);
$('#openMov').click(toolbar.confirmSaveChanges);
$('#deleteMov').click(toolbar.confirmDeleteMov);
$('#cancelMov').click(toolbar.confirmCancelMov);
