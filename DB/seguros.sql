CREATE DATABASE IF NOT EXISTS seguros;

USE seguros;

CREATE TABLE cotizar (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tipo varchar(20) NOT NULL,
  basico int(11) NOT NULL,
  estandar int(11) NOT NULL,
  premiun int(11) NOT NULL
);

INSERT INTO cotizar (`tipo`, `basico`, `estandar`, `premiun`) VALUES
('vida', 1000, 1500, 2000),
('vivienda', 1800, 2300, 3000),
('vehiculo', 1700, 2200, 2800);

CREATE TABLE usuarios (
  id int(11) NOT NULL PRIMARY KEY,
  tipo_documento varchar(50) NOT NULL,
  names varchar(150) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  rol tinyint(1) NOT NULL DEFAULT 0,
  active tinyint(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE clientes (
  id int(11) NOT NULL PRIMARY KEY,
  tipo_documento varchar(50) NOT NULL,
  names varchar(150) NOT NULL,
  email varchar(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE vida (
  ref_pago int(11) NOT NULL PRIMARY KEY,
  id_user int(11) NOT NULL,
  id_beneficiario int(11) NOT NULL,
  fecha_nacimineto date NOT NULL,
  sexo varchar(20) NOT NULL,
  estado_civil varchar(20) NOT NULL,
  celular varchar(20) NOT NULL,
  direccion varchar(150) NOT NULL,
  ciudad varchar(100) NOT NULL,
  ingresos int(11) NOT NULL,
  profesion varchar(100) NOT NULL,
  medicamento varchar(20) NOT NULL,
  cual varchar(100) NOT NULL,
  eps_ips varchar(100) NOT NULL,
  fecha_inicio date NOT NULL,
  fecha_fin date NOT NULL,
  tipo varchar(50) NOT NULL,
  plan varchar(20) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_user) REFERENCES usuarios (id),
  FOREIGN KEY (id_beneficiario) REFERENCES clientes (id)
);

CREATE TABLE pagos (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  ref_pago int(11) NOT NULL,
  valor int(11) NOT NULL,
  pago tinyint(1) NOT NULL DEFAULT 0,
  activo tinyint(1) NOT NULL DEFAULT 0,
  cancelado tinyint(1) NOT NULL DEFAULT 0,
  reclamado tinyint(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (ref_pago) REFERENCES vida (ref_pago)
);

CREATE TABLE solicitudes (
  id_solicitud int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  fecha_solicitud TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  estado tinyint(1) NOT NULL DEFAULT 0,
  ref_pago int(11) NOT NULL,
  update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (ref_pago) REFERENCES vida (ref_pago)
);

CREATE TABLE auditoria (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_usuario int(11) NOT NULL,
  ip varchar(100) NOT NULL,
  fecha_hora TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  descripcion varchar(255) NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES usuarios (id)
);
