<?php
  $serverName= 'localhost';
  $connectionInfo=array ("Database"=>"Empleados","UID"=>"sa","PWD"=>"1234","CharacterSet"=>"UTF-8");
  $conn = sqlsrv_connect($serverName,$connectionInfo); 

   if($conn){
      echo "";
   }
   else{
       echo "fallo en la conexion";
       die (print_r(sqlsrv_errors(),true));
   }

?>