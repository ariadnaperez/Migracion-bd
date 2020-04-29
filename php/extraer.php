<?php
    include "./conexionServer.php";

    //trae las bases de datos
    $sql1 = "SELECT name FROM sysdatabases order by crdate";
    $stmt1 = sqlsrv_query( $conn, $sql1 );
    
    //trae las tablas de la base de datos
    $sql3 = "SELECT * FROM sys.tables WHERE name != 'sysdiagrams' ORDER BY name";
    $stmt3 = sqlsrv_query( $conn, $sql3 );
    
    //trae los nombre de los campos,el tipo de dato y el maximo de caracteres
    $sql4 = "SELECT COLUMN_NAME,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH FROM
     Information_Schema.Columns WHERE TABLE_NAME='$name'";
    $stmt4 = sqlsrv_query( $conn, $sql4 );
    
?>

