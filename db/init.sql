CREATE TABLE Roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE Permisos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripción TEXT
);

CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    correo VARCHAR(255) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol_id INT,
    FOREIGN KEY (rol_id) REFERENCES Roles(id)
);

CREATE TABLE Departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE Empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    departamento_id INT,
    usuario_id INT UNIQUE,
    FOREIGN KEY (departamento_id) REFERENCES Departamentos(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

CREATE TABLE Visitantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    tipo_identificación VARCHAR(50),
    número_identificación VARCHAR(255) UNIQUE,
    empresa VARCHAR(255),
    contacto_empleado_id INT,
    FOREIGN KEY (contacto_empleado_id) REFERENCES Empleados(id)
);

CREATE TABLE TiposVisita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripción TEXT
);

CREATE TABLE Visitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visitante_id INT,
    fecha_entrada DATETIME,
    fecha_salida DATETIME,
    motivo TEXT,
    tipo_visita_id INT,
    FOREIGN KEY (visitante_id) REFERENCES Visitantes(id),
    FOREIGN KEY (tipo_visita_id) REFERENCES TiposVisita(id)
);

CREATE TABLE Alertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(255) NOT NULL,
    descripción TEXT,
    fecha DATETIME NOT NULL
);

CREATE TABLE Reportes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(255) NOT NULL,
    fecha_inicio DATETIME,
    fecha_fin DATETIME
);

CREATE TABLE ConfiguracionesSeguridad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    valor VARCHAR(255) NOT NULL
);


INSERT INTO Roles (nombre) VALUES ('Administrador'), ('Recepcionista'), ('Seguridad');

INSERT INTO Permisos (nombre, descripción) VALUES ('Crear Usuario', 'Permite crear nuevos usuarios'), ('Registrar Visita', 'Permite registrar una nueva visita');

INSERT INTO Departamentos (nombre) VALUES ('Tecnología'), ('Recursos Humanos');

INSERT INTO Usuarios (nombre, correo, contraseña, rol_id) VALUES ('Juan Perez', 'juan.perez@example.com', 'contraseña123', 1);

INSERT INTO Empleados (nombre, departamento_id, usuario_id) VALUES ('Ana Gomez', 1, 1);

INSERT INTO Visitantes (nombre, tipo_identificación, número_identificación, empresa, contacto_empleado_id) VALUES ('Carlos Ruiz', 'DNI', '12345678A', 'Empresa X', 1);

INSERT INTO TiposVisita (nombre, descripción) VALUES ('Proveedor', 'Visita de proveedores'), ('Cliente', 'Visita de clientes');

INSERT INTO Visitas (visitante_id, fecha_entrada, fecha_salida, motivo, tipo_visita_id) VALUES (1, NOW(), NOW() + INTERVAL 1 HOUR, 'Reunión con departamento de Tecnología', 2);

INSERT INTO Alertas (tipo, descripción, fecha) VALUES ('Acceso no autorizado', 'Intento de acceso no autorizado detectado', NOW());

INSERT INTO Reportes (tipo, fecha_inicio, fecha_fin) VALUES ('Informe de visitas', NOW() - INTERVAL 1 MONTH, NOW());

INSERT INTO ConfiguracionesSeguridad (nombre, valor) VALUES ('Nivel de acceso mínimo', 'Bajo');
