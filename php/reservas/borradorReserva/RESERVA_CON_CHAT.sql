DROP DATABASE IF EXISTS reserva_con_chat;
CREATE DATABASE reserva_con_chat;
USE reserva_con_chat;

CREATE TABLE cancha(
	id_cancha INT AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(50)
);

CREATE TABLE hora(
	id_hora INT AUTO_INCREMENT PRIMARY KEY,
	hora_inicio TIME,
	hora_fin TIME,
);

CREATE TABLE reserva(
	id_reserva INT AUTO_INCREMENT PRIMARY KEY,
	fecha DATE,
	rela_cancha INT,
	rela_hora INT,
	FOREIGN KEY (rela_cancha) REFERENCES cancha(id_cancha),
	FOREIGN KEY (rela_hora) REFERENCES hora(id_hora)
);

#INSERTS
INSERT INTO cancha VALUES(1,'YPF');#ID,nombre
INSERT INTO cancha VALUES(2,'San Martin');#ID,nombre
INSERT INTO cancha VALUES(3,'Le club');#ID,nombre

INSERT INTO hora VALUES(2,'14:00','15:00');#ID,Hinicio,Hfin
INSERT INTO hora VALUES(3,'15:00','16:00');#ID,Hinicio,Hfin
INSERT INTO hora VALUES(4,'16:00','17:00');#ID,Hinicio,Hfin
INSERT INTO hora VALUES(5,'17:00','18:00');#ID,Hinicio,Hfin
INSERT INTO hora VALUES(6,'18:00','19:00');#ID,Hinicio,Hfin

INSERT INTO reserva VALUES(1,'2023-09-27',1,2);#ID,Fecha,RelaCancha,RelaHora
INSERT INTO reserva VALUES(2,'2023-09-27',1,5);#ID,Fecha,RelaCancha,RelaHora
INSERT INTO reserva VALUES(3,'2023-09-27',1,6);#ID,Fecha,RelaCancha,RelaHora
/*
SELECT 
			h.id_hora,
			h.hora_inicio,
    		h.hora_fin,
    		r.id_reserva,
   			IF (r.id_reserva IS NULL, 'disponible', 'no-disponible') AS estado
		FROM hora as h
			LEFT JOIN `reserva` AS r ON h.id_hora = r.rela_hora AND r.fecha = '2023-09-27'
        WHERE h.hora_inicio >= '14:00' AND h.hora_inicio <= '20:00'
		ORDER BY (h.hora_inicio);*/