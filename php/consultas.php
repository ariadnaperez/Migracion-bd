<?php
    include "./conexion.php";

   $sql = "SELECT pnombre, papellido FROM Empleado";
   $stmt = sqlsrv_query( $conn, $sql);
   while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
       echo "<br></br>";
      echo $row['pnombre']." ".$row['papellido']."<br />";
   }

   sqlsrv_free_stmt( $stmt);
?>
