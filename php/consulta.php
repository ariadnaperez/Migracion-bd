<?php
    include "./conexion.php";

    $sql = "SELECT name FROM sysdatabases order by crdate";
   $stmt = sqlsrv_query( $conn, $sql );
   echo "<br>"."Bases de Datos existentes en SQL Server:";
   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo "<br>".$row['name']."<br>";
   }

   sqlsrv_free_stmt( $stmt);

   $sql = "SELECT column_name, data_type  FROM Information_Schema.Columns
   WHERE TABLE_NAME = 'Empleado'
   ORDER BY COLUMN_NAME";
   $stmt = sqlsrv_query( $conn, $sql );
   echo "<br>"."Tablas existentes en la base de datos: Empleado";
   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo "<br>".$row['column_name']."     ---->    ";
      echo $row['data_type']."<br>";
   }

   sqlsrv_free_stmt( $stmt);
?>