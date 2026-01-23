$(document).ready(function() {

	$('#uploadimage').click(function() {
    	$('#fileuploadimage').trigger('click');
	});
	$('#fileuploadimage').change(function() {
		var formData = new FormData();
		formData.append('image', $(this)[0].files[0]);
		formData.append('bannerhref', $('#bannerhref').val());
		$.ajax({
			url: 'ajaxjs/mainslider/convertandupload_imagen.php',
			type: 'POST',
			data: formData,
			processData: false,
			contentType: false,
    		dataType: 'json', // Esperamos una respuesta JSON
    		success: function(rpse) {

      		},
      		error: function() {
      			bannerhref
      		}
  		});
	});

    $(".dns_trashbanner").click(function() {
        var imagen = $(this).data("imagen");
        var mainslider = $(this).data("mainslider");

        // Enviar una solicitud AJAX para eliminar la imagen usando PHP
        $.post("ajaxjs/mainslider/eliminar_imagen.php", { imagen: imagen, mainslider: mainslider })
            .done(function(data) {
                // Si la eliminación fue exitosa, elimina la imagen del DOM
                $(".imagenAEliminar[src='" + imagen + "']").parent().remove();
                console.log("Imagen eliminada exitosamente.");
            })
            .fail(function(xhr, status, error) {
                // Si hay un error en la solicitud AJAX, mostrar un mensaje de error
                console.error("Error al eliminar la imagen:", error);
            });
    });
});