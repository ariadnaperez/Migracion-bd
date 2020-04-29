INSERT INTO [dbo].[Empleado]
([idEmpleado]
,[pnombre]
,[snombre]
,[papellido]
,[direccion]
,[telefono]
,[celular]
,[incrementoSueldo])
VALUES 
(1,'Ariadna','Andrea','Perez','Col.Kennedy','2221-4567','991934-45','5000'),
(2,'Alejandra','Ines','Garcia','Col.Pedregal','2231-6678','994944-55','6000'),
(3,'Maria','Jos�','Guti�rrez','Col.Proceres','2221-4192','992766-27','8000'),
(4,'Ana','Maria','Martinez','Col.Lomas','2332-4554','98877665','1000'),
(5,'Pedro','Jose','Caceres','Col.Las Colinas','2112-3445','99180909','900'),
(6,'Carlos','ALfonso','Herrera','Col.Trinidad','2134-5678','98234567','8000'),
(7,'Sara','Sofia','Hernandez','Col.Minas','2123-5667','34567890','244'),
(8,'Angela','Luz','Banegas','Col.Miramontes','2109-8765','90876543','9832'),
(9,'Carmen','Alejandra','Garcia','Col.San Juan','2456-7890','90123456','934'),
(10,'Juan','Daniel','Sanchez','Col.Pedregal','2312-3456','99876543','983')


INSERT INTO [dbo].[Cargo]
([IdCargo]
,[nombreCargo]
,[sueldoBase])
VALUES (4,'Marketing','9500'),
       (5,'Recursos_Humanos','15000'),
      (6,'Gerente_Logística','27000'),
      (7,' Gerente_TI','29000'),
       (8,'Gerente_Comercial','26000'),
       (9,'Comunicaciones ','33000'),
       (10,'Servicios','13000')


INSERT INTO [dbo].[TIPO]
([IdTipoDeduccion]
,[descripcion])
VALUES (1,'F'),
       (2,'GO'),
	   (3,'SV'),
	   (4,'V'),
	   (5,'Int'),
	   (6,'Imp'),
	   (7,'GM'),
	   (8,'PP'),
	   (9,'D'),
	   (10,'SS')


INSERT INTO [dbo].[Deduccion]
([idDeduccion]
,[fechaInicio]
,[fechaFin]
,[valor]
,[idTipoDeduccion])
VALUES  (1,'10/8/2017','10/8/2019','5000',2),
	    (2,'15/1/2016','15/1/2018','300',3),
	   (3,'22/3/2018','22/5/2020','500',4),
	   (4,'15/4/2015','15/9/2018','200',5),
	   (5,'12/2/2018','12/2/2020','2000',1),
	   (6,'18/11/2014','18/10/2017','800',6),
	   (7,'25/8/2012','25/8/2015','1200',7),
	   (8,'17/3/2019','17/3/2020','150',8),
	   (9,'15/2/2015','15/5/2018','200',9),
	   (10,'16/5/2018','16/5/2019','600',10)


INSERT INTO [dbo].[CARGO_x_EMPLEADO]
([IdCargo]
,[idEmpleado]
,[fechaNombramiento]
,[fechaFin])
VALUES (1,1,'12/2/2018','12/2/2020'),
		(2,2,'01/2/2018','01/2/2020'),
		(3,3,'05/2/2018','05/2/2020'),
		(4,5,'11/11/2009','11/11/2011'),
		(5,6,'02/09/2012','03/01/2013'),
		(6,7,'10/02/2011','09/02/2012'),
		(7,8,'09/04/2013','08/06/2015'),
		(8,9,'02/03/2016','06/07/2019'),
		(9,10,'08/05/2015','04/02/2018'),
		(10,4,'04/09/2019','01/07/2020')

INSERT INTO [dbo].[DEDUCCION_X_EMPLEADO]
([Fecha]
,[Estado]
,[idEmpleado]
,[idDeduccion])
VALUES ('12/2/2018','f',3,5),
('12/8/2018','p',4,6),
('12/9/2017','f',5,7),
('12/12/2018','p',6,8),
('12/2/2016','f',7,9),
('12/4/2015','p',8,10),
('12/2/2014','f',9,1),
('12/5/2017','p',10,2),
('12/3/2018','f',1,3),
('12/1/2020','p',2,4)
