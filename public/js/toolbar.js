var toolbar = {

	confirmSaveChanges : function(){

		$('#confirmModalBody').html('¿Guardar cambios?');
		$('#confirmModal').modal('show');
	},

	confirmCancelMov : function(){

		$('#confirmModalBody').html('<img src="/img/warning.png"> ¿Cancelar el movimiento?');
		$('#confirmModal').modal('show');
	},

	confirmDeleteMov : function(){

		$('#confirmModalBody').html('<img src="/img/warning.png"> ¿Eliminar el movimiento?');
		$('#confirmModal').modal('show');
	}
};

$('#newMov').click(toolbar.confirmSaveChanges);
$('#openMov').click(toolbar.confirmSaveChanges);
$('#deleteMov').click(toolbar.confirmDeleteMov);
$('#cancelMov').click(toolbar.confirmCancelMov);
