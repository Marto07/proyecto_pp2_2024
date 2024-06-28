USE proyecto_pp2;

SELECT id_usuario,password FROM usuarios JOIN contacto ON usuarios.rela_contacto = contacto.id_contacto WHERE descripcion_contacto = 'maurinasd@gmail.com';

