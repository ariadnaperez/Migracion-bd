<?php
  $serverName= 'localhost';
  $connectionInfo=array ("Database"=>"Empleados","UID"=>"sa","PWD"=>"asd.4567","CharacterSet"=>"UTF-8");
  $conn = sqlsrv_connect($serverName,$connectionInfo); 

   if($conn){
      /*echo "conexion exitosa";*/
      $status = 1;
   }
   else{
       echo "fallo en la conexion";
       die (print_r(sqlsrv_errors(),true));
   }

?>