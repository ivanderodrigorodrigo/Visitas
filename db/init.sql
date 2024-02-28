CREATE DATABASE DB_PIIS;
USE DB_PIIS;

CREATE TABLE ROLES (
	id_rol INT PRIMARY KEY AUTO_INCREMENT,
	nombre_rol VARCHAR (50)
);

CREATE TABLE PERMISOS (
	id_permiso INT PRIMARY KEY AUTO_INCREMENT,
	nombre_permiso VARCHAR (50)
);

CREATE TABLE ROLES_PERMISOS (
	id_rol INT ,
	id_permiso INT,
	PRIMARY KEY (id_rol,id_permiso),
    FOREIGN KEY (id_rol) REFERENCES ROLES(id_rol),
    FOREIGN KEY (id_permiso) REFERENCES PERMISOS(id_permiso)
);

CREATE TABLE EMPLEADOS (
	id_emp INT PRIMARY KEY AUTO_INCREMENT,
    dni_emp VARCHAR(9) NOT NULL UNIQUE,
    nombre_emp VARCHAR (50) NOT NULL,
    apellido_emp VARCHAR (100) NOT NULL,
    email_emp VARCHAR (100),
    contrasenya_emp VARCHAR(250), 
	rol_id int not null,
	activo_emp char(1) DEFAULT 'S',
    estado_id INT,
    FOREIGN KEY (rol_id) REFERENCES ROLES(id_rol),
    FOREIGN KEY (estado_id) REFERENCES ESTADOS_EMP(id_estado)
);	

CREATE TABLE EMPRESA (
	id_empresa INT PRIMARY KEY AUTO_INCREMENT,
    nombre_empresa VARCHAR (100),
    hora_ini_empresa TIME,
    hora_fin_empresa TIME,
    aforo_max_empresa INT,
    num_empleados INT
);	

CREATE TABLE VISITANTES (
	id_visitante INT PRIMARY KEY AUTO_INCREMENT,
    dni_visitante VARCHAR(9) NOT NULL UNIQUE,
    nombre_visitante VARCHAR (50) NOT NULL,
    apellido_visitante VARCHAR (100) NOT NULL,
    email_visitante VARCHAR (100) NOT NULL,
    verificado_visitante CHAR(1) DEFAULT 'N',
    empresa_visitante VARCHAR(100) DEFAULT 'NA',
	activo_visitante char(1) DEFAULT 'S'
);	

CREATE TABLE ESTADOS_VISITA (
	id_estado INT PRIMARY KEY AUTO_INCREMENT,
    nombre_estado VARCHAR(50) NOT NULL
);

CREATE TABLE MOTIVOS_VISITA (
	id_motivo INT PRIMARY KEY AUTO_INCREMENT,
    descripcion_motivo VARCHAR(100) NOT NULL
);


CREATE TABLE VISITAS (
	id_visita INT PRIMARY KEY AUTO_INCREMENT,
    id_visitante INT NOT NULL,
    fecha_visita DATETIME,
    duracion_visita INT,
    id_motivo INT,
    invistacion CHAR(1),
	id_emp_alta INT NOT NULL,
    fecha_entrada DATETIME,
    fecha_salida DATETIME,
    id_estado INT,
    FOREIGN KEY (id_visitante) REFERENCES VISITANTES(id_visitante),
    FOREIGN KEY (id_motivo) REFERENCES MOTIVOS_VISITA(id_motivo),
    FOREIGN KEY (id_emp_alta) REFERENCES EMPLEADOS(id_emp),
    FOREIGN KEY (id_estado) REFERENCES ESTADOS_VISITA(id_estado)
);	


CREATE TABLE HISTORICO (
	id_historico INT PRIMARY KEY AUTO_INCREMENT,
    id_visita INT NOT NULL,
    fecha_alerta DATETIME,
    acceso_denegado CHAR(1) DEFAULT 'N',
    info_extra VARCHAR(250),
    FOREIGN KEY (id_visita) REFERENCES VISITAS(id_visita)
);	


CREATE TABLE APP_LOGS (
	id_log INT PRIMARY KEY AUTO_INCREMENT,
    id_emp INT NOT NULL,
    fecha_log DATETIME,
    info_extra TEXT,
    FOREIGN KEY (id_emp) REFERENCES EMPLEADOS(id_emp)
);	


CREATE TABLE MODULOS (
	id_modulo INT PRIMARY KEY AUTO_INCREMENT,
    nombre_modulo VARCHAR(50)
);	

CREATE TABLE MODULOS_ROLES (
	id_modulo INT,
    id_rol INT,
    PRIMARY KEY (id_rol,id_modulo)
);	

CREATE TABLE ESTADOS_EMP (
    id_estado INT PRIMARY KEY AUTO_INCREMENT,
    nombre_estado VARCHAR(50)
);


DROP TRIGGER IF EXISTS `db_piis`.`EMPLEADOS_AFTER_INSERT`;

DELIMITER $$
USE `db_piis`$$
CREATE DEFINER = CURRENT_USER TRIGGER `db_piis`.`EMPLEADOS_AFTER_INSERT` AFTER INSERT ON `EMPLEADOS` FOR EACH ROW
BEGIN
 UPDATE empresa SET num_empleados = num_empleados + 1;
END$$
DELIMITER ;

DROP TRIGGER IF EXISTS `db_piis`.`EMPLEADOS_AFTER_UPDATE`;

DELIMITER $$
USE `db_piis`$$
CREATE DEFINER = CURRENT_USER TRIGGER `db_piis`.`EMPLEADOS_AFTER_UPDATE` AFTER UPDATE ON `EMPLEADOS` FOR EACH ROW
BEGIN
	DECLARE num_emp INT;
	set num_emp = (SELECT COUNT(*) FROM empleados WHERE activo_emp = 'S');
    
    UPDATE empresa SET num_empleados = num_emp;
END$$
DELIMITER ;


insert into empresa (nombre_empresa, hora_ini_empresa, hora_fin_empresa, aforo_max_empresa, num_empleados)
values ('PresentiaL SL', '08:00:00', '18:00:00', 100, 0);

INSERT INTO `db_piis`.`roles`
(`nombre_rol`)
VALUES ('Administrador'), ('Recepcionista'),('Seguridad');

INSERT INTO `db_piis`.`empleados`(`dni_emp`,`nombre_emp`,`apellido_emp`,`email_emp`,`contrasenya_emp`,`rol_id`,`activo_emp`)
VALUES ('12345678P','Admin', 'Admin','admin@gmail.com','123456',1, 'S');

INSERT INTO ESTADOS_EMP (nombre_estado) VALUES ('Soltero/a'),('Casado/a'),('Divorciado/a'),('Viudo/a');  