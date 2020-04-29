CREATE TABLE CARGO 
( 
idCargo INT PRIMARY KEY NOT NULL,
nombreCargo VARCHAR (45),
sueldoBase MONEY) 
;

CREATE TABLE EMPLEADO(
idEmpleado INT PRIMARY KEY NOT NULL,
pnombre VARCHAR(45),
snombre VARCHAR(45),
papellido VARCHAR(45),
direccion VARCHAR(60),
telefono  VARCHAR(30),
celular  VARCHAR(15),
incrementoSueldo MONEY 
);

CREATE TABLE CARGO_x_EMPLEADO 
( 
   idEmpleado INT,
   idCargo INT ,
   fechaNombramiento DATETIME,
  fechaFin DATETIME,
  CONSTRAINT fk_Empleado_idEmmpleado FOREIGN KEY (idEmpleado) REFERENCES EMPLEADO (idEmpleado),
    CONSTRAINT fk_Cargo_idCargo FOREIGN KEY (idCargo) REFERENCES CARGO (idCargo)

  )
;


CREATE TABLE DEDUCCION_X_EMPLEADO
(
 Fecha DATETIME,
 Estado VARCHAR (1),
 idEmpleado INT,
 idDeduccion INT,
  CONSTRAINT fk_Empleado_idEmmpleado_deduccion FOREIGN KEY (idEmpleado) REFERENCES EMPLEADO (idEmpleado),
    CONSTRAINT fk_Deduccion_idDeduccion FOREIGN KEY (idDeduccion) REFERENCES DEDUCCION (idDeduccion)
);

CREATE TABLE DEDUCCION
(
idDeduccion INT PRIMARY KEY,
fechaInicio DATETIME,
fechaFin DATETIME,
valor MONEY,
 idTipoDeduccion INT,
  CONSTRAINT fk_tipo_idTipoDeduccion FOREIGN KEY (idTipoDeduccion) REFERENCES TIPO (idTipoDeduccion)
  );

CREATE TABLE TIPO(
 idTipoDeduccion INT PRIMARY KEY,
 descripcion VARCHAR(45)
)
;

