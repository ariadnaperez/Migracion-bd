<?php
include "./conexionOracle.php";
include "./extraer.php";

while ($row= sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)) {
    $name = $row['name'];
    crearTabla($conexion2,$name);
    while ($row= sqlsrv_fetch_array($stmt4,SQLSRV_FETCH_ASSOC)) {
        $nombreColumna = $row['COLUMN_NAME'];
        $tipoDato = $row['DATA_TYPE'];
    }
    }
function crearTabla($conexion2,$name){
    $sql1 = "CREATE TABLE $name (TEMPORAL INT)";
        $stmt1 = oci_parse($conexion, $sql1);
        $ok1 = oci_execute( $stmt1 );
        oci_free_statement( $stmt1 );
        return $ok1;
}



?>