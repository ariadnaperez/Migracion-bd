<?php
    include "./conexion.php";

    $sql1 = "SELECT name FROM sysdatabases order by crdate";
    $stmt1 = sqlsrv_query( $conn, $sql1 );

    $sql2 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams' ORDER BY name";
    $stmt2 = sqlsrv_query( $conn, $sql2 );
    
    $sql3 = "SELECT COLUMN_NAME,DATA_TYPE FROM Information_Schema.Columns
    WHERE TABLE_NAME = 'Empleado'
    ORDER BY COLUMN_NAME";
    $stmt3 = sqlsrv_query( $conn, $sql3 );
    


?>
