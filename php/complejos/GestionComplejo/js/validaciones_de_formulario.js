$(document).ready(function() {
	//PARAMETROS DE VALIDACIONES PASO 1
	let regex_complejo = /^[a-zA-Z0-9\s]{3,}$/;
	let regex_fecha_fundacion_complejo = /^\d{4}-\d{2}-\d{2}$/;

	let descripcion_complejo_error 		= true;
	let fecha_fundacion_complejo_error 	= true;

	//PARAMETROS DE VALIDACIONES PASO 2
	let regex_sucursal = /^[a-zA-Z0-9\s]{3,}$/;
	let regex_direccion = /^[a-zA-Z0-9\s.,/-]{5,}$/;
	let regex_fecha_fundacion_sucursal = /^\d{4}-\d{2}-\d{2}$/;

	let descripcion_sucursal_error 		= true;
	let direccion_error			 		= true;
	let fecha_fundacion_sucursal_error 	= true;
	let select_provincia_error 			= true;
	let select_localidad_error 			= true;
	let select_barrio_error 			= true;

	//PARAMETROS DE VALIDACIONES PASO 3
	let descripcion_zona_error			= true;
	let select_tipo_terreno_error       = true;
	let select_deporte_error 			= true;
	let select_formato_deporte_error 	= true;
	let select_estado_zona_error 		= true;

	//VALIDACIONES PASO 1
		//validacion nombre complejo 
		$("#descripcion_complejo").on("blur", function() {
			let descripcion_complejo = $(this).val();

			if(!regex_complejo.test(descripcion_complejo)) {
				$("#error_descripcion_complejo").html('El nombre debe tener al menos 3 carácteres, no se permiten ". - _ /"').css({
					"display":"block",
					"color":"#e65715",
				});
				descripcion_complejo_error = true;
				console.log("complejo: " + descripcion_complejo_error);
			} else {
				$("#error_descripcion_complejo").hide();
				descripcion_complejo_error = false;
				console.log("complejo: " + descripcion_complejo_error);
			}

		});

		//validacion fecha de fundacion complejo
		$("#fecha_fundacion_complejo").on("blur", function() {
			//obtenemos la fecha del input a un objeto javascript
			let fecha_ingresada_complejo = $(this).val();
			let partes = fecha_ingresada_complejo.split('-');
			let fecha = new Date(partes[0], partes[1] - 1, partes[2])
			// console.log(fecha);

			//seteamos la hora actual
			let hoy_complejo = new Date();
			hoy_complejo.setHours(0, 0, 0, 0);

			if(!regex_fecha_fundacion_complejo.test(fecha_ingresada_complejo) || (fecha >= hoy_complejo)) {
				$("#error_fecha_fundacion_complejo").html('La fecha ingresada no puede ser igual o superior a hoy').css({
					"display":"flex",
					"color":"#e65715",
				});
				fecha_fundacion_complejo_error = true;
				// console.log("fecha complejo: " + fecha_fundacion_complejo_error);
			} else {
				$("#error_fecha_fundacion_complejo").hide();
				fecha_fundacion_complejo_error = false;
				// console.log("fecha complejo: " + fecha_fundacion_complejo_error);
			}

		});

	//VALIDACIONES PASO 2
		//validacion de nombre sucursal
		$("#descripcion_sucursal").on("blur", function() {

			let descripcion_sucursal = $(this).val();

			if (!regex_sucursal.test(descripcion_sucursal)) {
				$("#error_descripcion_sucursal").html(
					'El nombre debe tener al menos 3 carácteres, no se permiten caracteres como " . - _ / "'
				).css({
					"display":"block",
					"color":"#e65715",
				});
				descripcion_sucursal_error = true;
			} else {
				$("#error_descripcion_sucursal").hide();
				descripcion_sucursal_error = false;
			}

		}); 

		//validacion de direccion sucursal
		$("#direccion").on("blur", function() {

			let direccion = $(this).val();

			if(!regex_direccion.test(direccion)) {
				$("#direccion_error").html(
					'La direccion debe tener al menos 5 carácteres, no se permiten simbolos salgo ". / - ,"'
				).css({
					"display":"block",
					"color":"#e65715",
				});
				direccion_error = true;
			} else {
				$("#direccion_error").hide();
				direccion_error = false;
			}

		});

		$("#fecha_fundacion_sucursal").on("blur", function() {
			//SETEAMOS EL VALOR RECIBIDO A UN OBJETO JAVASCRIPT
			let fecha_ingresada_sucursal = $(this).val();
			let partes = fecha_ingresada_sucursal.split('-');
			let fecha = new Date(partes[0], partes[1] - 1, partes[2])

			//SEATEAMOS LA FECHA ACTUAL
			let hoy_sucursal = new Date();
			hoy_sucursal.setHours(0, 0, 0, 0); 
			// console.log(fecha);
			if(!regex_fecha_fundacion_sucursal.test(fecha_ingresada_sucursal) || (fecha >= hoy_sucursal)) {
				$("#error_fecha_fundacion_sucursal").html('La fecha ingresada no puede ser nula, igual o superior a hoy').css({
					"display":"block",
					"color":"#e65715",
				});
				fecha_fundacion_sucursal_error = true;
			} else {
				$("#error_fecha_fundacion_sucursal").hide();
				fecha_fundacion_sucursal_error = false;
			}

		});

		//validamos el nombre de la zona
		$("#descripcion_zona").on("blur", function() {

			let descripcion_zona = $(this).val();

			if (!regex_sucursal.test(descripcion_zona)) {
				$("#error_descripcion_zona").html(
					'El nombre debe tener al menos 3 carácteres, no se permiten caracteres como " . - _ / "'
				).css({
					"display":"block",
					"color":"#e65715",
				});
				descripcion_zona_error = true;
			} else {
				$("#error_descripcion_zona").hide();
				descripcion_zona_error = false;
			}

		}); 

		//VALIDAMOS LOS SELECT

		//deporte
		$("#deporte").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_deporte_error = false;
				console.log("Error deporte: " + select_deporte_error);
			} else {
				select_deporte_error = true;
				console.log("Error deporte: " + select_deporte_error);
			}

		});

		//formato deporte
		$("#formato_deporte").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_formato_deporte_error = false;
				console.log("Error tipo deporte: " + select_formato_deporte_error);
			} else {
				select_formato_deporte_error = true;
				console.log("Error tipo deporte: " + select_formato_deporte_error);
			}

		});

		//estado
		$("#estado_zona").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_estado_zona_error = false;
				console.log("Error estado zona: " + select_estado_zona_error);
			} else {
				select_deporte_error = true;
				console.log("Error estado zona: " + select_estado_zona_error);
			}

		});

		//superficie
		$("#tipo_terreno").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_tipo_terreno_error = false;
				console.log("Error superficie: " + select_tipo_terreno_error);
			} else {
				select_tipo_terreno_error = true;
				console.log("Error superficie: " + select_tipo_terreno_error);
			}

		});

		//provincia
		$("#provincia").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_provincia_error = false;
				console.log("Error provincia: " + select_provincia_error);
			} else {
				select_tipo_terreno_error = true;
				console.log("Error provincia: " + select_provincia_error);
			}

		});

		//localidad
		$("#localidad").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_localidad_error = false;
				console.log("Error localidad: " + select_localidad_error);
			} else {
				select_localidad_error = true;
				console.log("Error localidad: " + select_localidad_error);
			}

		});

		//barrio
		$("#barrio").on("change", function() {

			let id = $(this).val();

			if (id !== null && id !== '' ) {
				select_barrio_error = false;
				console.log("Error barrio: " + select_barrio_error);
			} else {
				select_barrio_error = true;
				console.log("Error barrio: " + select_barrio_error);
			}

		});










		//al finalizar el formulario
		$("#btn-finalizar").on("click", function () {

			if (
					//PARAMETROS PASO1
					descripcion_complejo_error 		== false &&
					fecha_fundacion_complejo_error 	== false &&

					//PARAMETROS DE VALIDACIONES PASO 2
					descripcion_sucursal_error 		== false &&
					direccion_error			 		== false &&
					fecha_fundacion_sucursal_error 	== false &&
					select_provincia_error 			== false &&
					select_localidad_error 			== false &&
					select_barrio_error 			== false &&

					//PARAMETROS DE VALIDACIONES PASO 3
					select_tipo_terreno_error       == false &&
					select_deporte_error 			== false &&
					select_formato_deporte_error 	== false &&
					select_estado_zona_error		== false 
				)
			{

				alert("no hay errores");
				$("#formulario").submit();
				
			} else {
				alert("hay errores, verifique el formulario");
			}

		});

});//document ready