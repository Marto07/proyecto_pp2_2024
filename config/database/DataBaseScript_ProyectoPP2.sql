DROP DATABASE IF EXISTS proyecto_pp2;
CREATE DATABASE proyecto_pp2;
USE proyecto_pp2;

CREATE TABLE provincia(
	id_provincia INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_provincia VARCHAR(50),
	estado BOOLEAN DEFAULT 1

);

CREATE TABLE localidad(
	id_localidad INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_localidad VARCHAR(50),
	rela_provincia INT,
	estado BOOLEAN DEFAULT 1,
	FOREIGN KEY (rela_provincia) REFERENCES provincia(id_provincia)
);

CREATE TABLE barrio(
	id_barrio INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_barrio VARCHAR(50),
	rela_localidad INT,
	estado BOOLEAN DEFAULT 1,
	FOREIGN KEY (rela_localidad) REFERENCES localidad(id_localidad)
);

CREATE TABLE sexo(
	id_sexo INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_sexo VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE tipo_documento(
	id_tipo_documento INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_tipo_documento VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE documento(
	id_documento INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_documento VARCHAR(50),
	estado BOOLEAN DEFAULT 1,
	rela_tipo_documento INT,
	FOREIGN KEY (rela_tipo_documento) REFERENCES tipo_documento(id_tipo_documento),
	UNIQUE(descripcion_documento, rela_tipo_documento)
);

CREATE TABLE tipo_contacto(
	id_tipo_contacto INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_tipo_contacto VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE persona(
	id_persona INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(50),
	apellido VARCHAR(50),
	cuil VARCHAR(50),
	fecha_nacimiento DATE,
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1,
	rela_documento INT,
	rela_sexo INT,
	FOREIGN KEY (rela_documento) REFERENCES documento(id_documento),
	FOREIGN KEY (rela_sexo) REFERENCES sexo(id_sexo)
);

CREATE TABLE contacto(
	id_contacto INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_contacto VARCHAR(50) UNIQUE,
	estado BOOLEAN DEFAULT 1,
	rela_tipo_contacto INT,
	rela_persona INT,
	FOREIGN KEY (rela_tipo_contacto) REFERENCES tipo_contacto(id_tipo_contacto),
	FOREIGN KEY (rela_persona) REFERENCES persona(id_persona)
);

CREATE TABLE servicio(
	id_servicio INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_servicio VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE complejo(
	id_complejo INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_complejo VARCHAR(50),
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE sucursal(
	id_sucursal INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_sucursal VARCHAR(50),
	direccion VARCHAR(50),
	estado BOOLEAN DEFAULT 1,
	rela_complejo INT,
	FOREIGN KEY (rela_complejo) REFERENCES complejo(id_complejo)
);

CREATE TABLE perfil(
	id_perfil INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_perfil VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE modulo(
	id_modulo INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_modulo VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL unique,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(100) NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'no verificado',
    rela_contacto INT NOT NULL unique,
    rela_perfil INT,
    FOREIGN KEY (rela_contacto) REFERENCES contacto(id_contacto),
    FOREIGN KEY (rela_perfil) REFERENCES perfil(id_perfil)
);

CREATE TABLE asignacion_perfil_modulo(
	id_asignacion_perfil_modulo INT AUTO_INCREMENT PRIMARY KEY,
	estado BOOLEAN DEFAULT 1,
	rela_perfil INT,
	rela_modulo INT,
	FOREIGN KEY (rela_perfil) REFERENCES perfil(id_perfil),
	FOREIGN KEY (rela_modulo) REFERENCES modulo(id_modulo)
);

CREATE TABLE asignacion_persona_complejo(
	id_asignacion_persona_complejo INT AUTO_INCREMENT PRIMARY KEY,
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1,
	rela_persona INT,
	rela_complejo INT,
	FOREIGN KEY (rela_persona) REFERENCES persona(id_persona),
	FOREIGN KEY (rela_complejo) REFERENCES complejo(id_complejo)
);

CREATE TABLE asignacion_persona_domicilio(
	id_asignacion_persona_domicilio INT AUTO_INCREMENT PRIMARY KEY,
	estado BOOLEAN DEFAULT 1,
	rela_persona INT,
	rela_barrio INT,
	FOREIGN KEY (rela_persona) REFERENCES persona(id_persona),
	FOREIGN KEY (rela_barrio) REFERENCES barrio(id_barrio)
);

CREATE TABLE asignacion_sucursal_domicilio(
	id_asignacion_sucursal_domicilio INT AUTO_INCREMENT PRIMARY KEY,
	estado BOOLEAN DEFAULT 1,
	rela_sucursal INT,
	rela_barrio INT,
	FOREIGN KEY (rela_sucursal) REFERENCES sucursal(id_sucursal),
	FOREIGN KEY (rela_barrio) REFERENCES barrio(id_barrio)
);

CREATE TABLE socio(
	id_socio INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_socio VARCHAR(50),
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1,
	rela_complejo INT,
	rela_persona INT,
	FOREIGN KEY (rela_complejo) REFERENCES complejo(id_complejo),
	FOREIGN KEY (rela_persona) REFERENCES persona(id_persona)
);

CREATE TABLE tarifa(
	id_tarifa INT AUTO_INCREMENT PRIMARY KEY,
	precio FLOAT,
	horario_desde TIME,
	horario_hasta TIME,
	turno ENUM('dia','noche'),
	estado BOOLEAN DEFAULT 1
);


CREATE TABLE asignacion_tarifa_servicio(
	id_asignacion_tarifa_servicio INT AUTO_INCREMENT PRIMARY KEY,
	estado BOOLEAN DEFAULT 1,
	rela_tarifa INT,
	rela_servicio INT,
	FOREIGN KEY (rela_tarifa) REFERENCES tarifa(id_tarifa),
	FOREIGN KEY (rela_servicio) REFERENCES servicio(id_servicio)
);

CREATE TABLE estado_zona(
	id_estado_zona INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_estado_zona VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);


#Futbol, voley, basquet
CREATE TABLE deporte(
	id_deporte INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_deporte VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

#futbol 5, voley playa, basquet 5
CREATE TABLE formato_deporte(
	id_formato_deporte INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_formato_deporte VARCHAR(50),
	estado BOOLEAN DEFAULT 1,
	rela_deporte INT,
	FOREIGN KEY (rela_deporte) REFERENCES deporte(id_deporte)
);

#cesped, piso, arena
CREATE TABLE tipo_terreno(
	id_tipo_terreno INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_tipo_terreno INT,
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE zona(
	id_zona INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_zona VARCHAR(50),
	dimension VARCHAR(50),
	estado BOOLEAN DEFAULT 1,
	rela_tipo_terreno INT,
	rela_formato_deporte INT,
	rela_estado_zona INT,
	rela_sucursal INT,
	rela_servicio INT,
	FOREIGN KEY (rela_tipo_terreno) REFERENCES tipo_terreno(id_tipo_terreno),
	FOREIGN KEY (rela_formato_deporte) REFERENCES formato_deporte(id_formato_deporte),
	FOREIGN KEY (rela_estado_zona) REFERENCES estado_zona(id_estado_zona),
	FOREIGN KEY (rela_sucursal) REFERENCES sucursal(id_sucursal),
	FOREIGN KEY (rela_servicio) REFERENCES servicio(id_servicio) 
);

CREATE TABLE estado_reserva(
	id_estado_reserva INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_estado_reserva VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE horario(
	id_horario INT AUTO_INCREMENT PRIMARY KEY,
	horario_inicio TIME,
	horario_fin tIME,
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1
);

CREATE TABLE reserva(
	id_reserva INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_reserva VARCHAR(50),
	fecha_reserva DATE,
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1,
	rela_estado_reserva INT,
	rela_persona INT,
	rela_zona INT,
	rela_horario INT,
	FOREIGN KEY (rela_estado_reserva) REFERENCES estado_reserva(id_estado_reserva),
	FOREIGN KEY (rela_persona) REFERENCES persona(id_persona),
	FOREIGN KEY (rela_zona) REFERENCES zona(id_zona),
	FOREIGN KEY (rela_horario) REFERENCES horario(id_horario)
);

CREATE TABLE evento(
	id_evento INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_evento VARCHAR(50),
	estado BOOLEAN DEFAULT 1,
	rela_servicio INT,
	FOREIGN KEY (rela_servicio) REFERENCES servicio(id_servicio)
);

CREATE TABLE equipo(
	id_equipo INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_equipo VARCHAR(50),
	estado BOOLEAN DEFAULT 1,
	rela_evento INT,
	FOREIGN KEY (rela_evento) REFERENCES evento(id_evento)
);

CREATE TABLE estado_control(
	id_estado_control INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_estado_control VARCHAR(50),
	estado BOOLEAN DEFAULT 1
);

#LA RESERVA DESPUES DE JUGAR, SE PAGO O NO SE PAGO, TIPO DE PAGO ETC...
CREATE TABLE control(
	id_control INT AUTO_INCREMENT PRIMARY KEY,
	descripcion_control VARCHAR(50), #observaciones
	metodo_pago VARCHAR(50),
	fecha_alta DATE,
	estado BOOLEAN DEFAULT 1,
	rela_estado_control INT,
	rela_reserva INT,
	FOREIGN KEY (rela_estado_control) REFERENCES estado_control(id_estado_control),
	FOREIGN KEY (rela_reserva) REFERENCES reserva(id_reserva)
);



