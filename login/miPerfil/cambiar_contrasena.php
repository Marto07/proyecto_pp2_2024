<script type="text/javascript">
	
	var contrasena1Input = $('#password1');
	var contrasena2Input = $('#password2');

	var contrasena1 = contrasena1Input.val();
	var contrasena2 = contrasena2Input.val();
	var regexcontrasena1 = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
	var regexcontrasena2 = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

	if (!regexcontrasena1.test(contrasena1)) {
	            event.preventDefault();
	            contrasena1Input.css('border', '2px solid #FF4500');
	            
	            alert('La contraseña debe tener almenos 8 caracteres y 1 número.');
	        } else {
	            contrasena1Input.css('border', '2px solid green');
	        }

	        if (!regexcontrasena2.test(contrasena2)) {
	            event.preventDefault();
	            contrasena2Input.css('border', '2px solid #FF4500');
	            alert('La nueva contraseña debe tener almenos 8 caracteres y 1 número.');
	        } else {
	            contrasena2Input.css('border', '2px solid green');
	        }
</script>