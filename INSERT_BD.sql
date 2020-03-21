INSERT INTO [dbo].[Empleado]
([idEmpleado]
,[pnombre]
,[snombre]
,[papellido]
,[direccion]
,[telefono]
,[celular]
,[incrementoSueldo])
VALUES (1,'Ariadna','Andrea','Perez','Col.Kennedy','2221-4567','991934-45','5000')

INSERT INTO [dbo].[Empleado]
([idEmpleado]
,[pnombre]
,[snombre]
,[papellido]
,[direccion]
,[telefono]
,[celular]
,[incrementoSueldo])
VALUES (2,'Alejandra','Ines','Garcia','Col.Pedregal','2231-6678','994944-55','6000')

INSERT INTO [dbo].[Empleado]
([idEmpleado]
,[pnombre]
,[snombre]
,[papellido]
,[direccion]
,[telefono]
,[celular]
,[incrementoSueldo])
VALUES (3,'Maria','Jos�','Guti�rrez','Col.Proceres','2221-4192','992766-27','8000')

INSERT INTO [dbo].[Cargo]
([IdCargo]
,[nombreCargo]
,[sueldoBase])
VALUES (1,'Administrador','15000')

INSERT INTO [dbo].[Cargo]
([IdCargo]
,[nombreCargo]
,[sueldoBase])
VALUES (2,'Vendedor','10000')


INSERT INTO [dbo].[Cargo]
([IdCargo]
,[nombreCargo]
,[sueldoBase])
VALUES (3,'Gerente','30000')

INSERT INTO [dbo].[CARGO_x_EMPLEADO]
([IdCargo]
,[idEmpleado]
,[fechaNombramiento]
,[fechaFin])
VALUES (1,1,'12/2/2018','12/2/2020')


INSERT INTO [dbo].[CARGO_x_EMPLEADO]
([IdCargo]
,[idEmpleado]
,[fechaNombramiento]
,[fechaFin])
VALUES (2,2,'01/2/2018','01/2/2020')


INSERT INTO [dbo].[CARGO_x_EMPLEADO]
([IdCargo]
,[idEmpleado]
,[fechaNombramiento]
,[fechaFin])
VALUES (3,3,'05/2/2018','05/2/2020')

INSERT INTO [dbo].[DEDUCCION_X_EMPLEADO]
([Fecha]
,[Estado]
,[idEmpleado]
,[idDeduccion])
VALUES ('12/2/2018','f',3,5)

INSERT INTO [dbo].[Deduccion]
([idDeduccion]
,[fechaInicio]
,[fechaFin]
,[valor]
,[idTipoDeduccion])
VALUES (5,'12/2/2018','12/2/2020','2000',1)

INSERT INTO [dbo].[TIPO]
([IdTipoDeduccion]
,[descripcion])
VALUES (1,'F')