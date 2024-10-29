$(document).ready(function () {

    $(document).on('click', '.eliminar', function() {
        let valor = $(this).attr('valor');
        // Mostrar SweetAlert con botones personalizados
        

        Swal.fire({
            title: '¿Seguro que desea eliminar este registro?',
            text: 'No podrás deshacer esta acción',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            width: '600px', // Se ajusta para ser similar al CSS de tu modal
            padding: '2rem',
            background: '#fff',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#47a386',
            showClass: {
                popup: 'animate__animated animate__fadeIn' // Transición de entrada
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut' // Transición de salida
            }
        }).then((result) => {
            // Si el usuario confirma
            if (result.isConfirmed) {
                // Llamar a la función 'confirmarEliminacion' pasando el id
                eliminar(valor, complejo);
            }
        });

    }); // #ELIMINAR ON CLICK

    function eliminar(id) {
        window.location.href = "../eliminar.php?id=" + id + "&id_complejo=" + complejo;
    }

}); //document ready