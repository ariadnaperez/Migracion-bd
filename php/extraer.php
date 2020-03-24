<?php
    include "./conexion.php";

    $sql1 = "SELECT name FROM sysdatabases order by crdate";
    $stmt1 = sqlsrv_query( $conn, $sql1 );

    $sql2 = "SELECT name FROM sys.tables WHERE name != 'sysdiagrams' ORDER BY name";
    $stmt2 = sqlsrv_query( $conn, $sql2 );
?>
