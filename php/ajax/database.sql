USE proyecto_pp2;


-- INSERT INTO `horario` (`id_horario`, `horario_inicio`, `horario_fin`, `fecha_alta`, `estado`) VALUES (NULL, '00:00:00', '01:00:00', CURRENT_DATE(), '1'), (NULL, '01:00:00', '02:00:00', CURRENT_DATE(), '1'), (NULL, '02:00:00', '03:00:00', CURRENT_DATE(), '1'), (NULL, '03:00:00', '04:00:00', CURRENT_DATE(), '1'), (NULL, '04:00:00', '05:00:00', CURRENT_DATE(), '1'), (NULL, '05:00:00', '06:00:00', CURRENT_DATE(), '1'), (NULL, '06:00:00', '07:00:00', CURRENT_DATE(), '1'), (NULL, '07:00:00', '08:00:00', CURRENT_DATE(), '1'), (NULL, '08:00:00', '09:00:00', CURRENT_DATE(), '1'), (NULL, '09:00:00', '10:00:00', CURRENT_DATE(), '1'), (NULL, '10:00:00', '11:00:00', CURRENT_DATE(), '1'), (NULL, '11:00:00', '12:00:00', CURRENT_DATE(), '1'), (NULL, '12:00:00', '13:00:00', CURRENT_DATE(), '1'), (NULL, '13:00:00', '14:00:00', CURRENT_DATE(), '1'), (NULL, '14:00:00', '15:00:00', CURRENT_DATE(), '1'), (NULL, '15:00:00', '16:00:00', CURRENT_DATE(), '1'), (NULL, '16:00:00', '17:00:00', CURRENT_DATE(), '1'), (NULL, '17:00:00', '18:00:00', CURRENT_DATE(), '1'), (NULL, '18:00:00', '19:00:00', CURRENT_DATE(), '1'), (NULL, '19:00:00', '20:00:00', CURRENT_DATE(), '1'), (NULL, '20:00:00', '21:00:00', CURRENT_DATE(), '1'), (NULL, '21:00:00', '22:00:00', CURRENT_DATE(), '1'), (NULL, '22:00:00', '23:00:00', CURRENT_DATE(), '1'), (NULL, '23:00:00', '00:00:00', CURRENT_DATE(), '1');

-- INSERT INTO `sucursal` (`id_sucursal`, `descripcion_sucursal`, `direccion`, `estado`, `rela_complejo`) VALUES (NULL, 'Sucursal YPF 1', 'Avenida avellaneda 235', '1', '1'), (NULL, 'Sucursal YPF 2', 'Avenida Napoleon 565', '1', '1'), (NULL, 'Sucursal YPF 3', 'Barrio Don Bosco calle sarmiento 277', '1', '1'), (NULL, 'LeClub 1', 'Avenida Gutniski', '1', '2'), (NULL, 'LeClub 2', 'Calle Domingo sarmiento 200', '1', '2'), (NULL, 'Sucursal FutBar1', 'Junin 728', '1', '3'), (NULL, 'Sucursal FutBar2', 'Avenida Uriburu 900', '1', '3');

SELECT  id_persona, 
                    nombre,
                    apellido,
                    descripcion_documento   AS documento,
                    descripcion_sexo        AS sexo
                FROM persona
                JOIN documento
                ON persona.rela_documento = documento.id_documento
                JOIN sexo
                ON persona.rela_sexo = sexo.id_sexo ;

CREATE TABLE membresia(
    id_membresia INT AUTO_INCREMENT PRIMARY KEY,
    beneficio_membresia VARCHAR(20),
    descripcion_membresia VARCHAR(100),#si fuera necesario
    precio_membrecia FLOAT,
    estado BOOLEAN DEFAULT 1,
);

CREATE TABLE socio(
    id_socio INT AUTO_INCREMENT PRIMARY KEY,
    descripcion_socio VARCHAR(50),
    rela_complejo INT,
    rela_membresia INT,
    fecha_afiliacion DATE,
    fecha_expiracion DATE,
    fecha_alta DATE,
    estado BOOLEAN DEFAULT 1,
    FOREIGN KEY (rela_complejo) REFERENCES complejo(id_complejo),
    FOREIGN KEY (rela_membresia) REFERENCES membresia(id_membresia)
);
