<?php
 include "./conexion.php";

    if(isset($_POST['nombre']) && isset($_POST["tabla"])) {
        $nombreBD = $_POST["Empleados"];
        $nombreTabla = $_POST["EMPLEADOS"];
        $serverName = "localhost";
        //aqui tambien solo poner la contraseña EN "PWD" =>""ya que $nombreBD contiene la base que tecleo y $nombreTabla la tabla que selecciono
        $infoConnection = array("Database"=>Empleados,"UID"=>"sa1","PWD"=>"1234","CharacterSet"=>"UTF-8");
        try {
            $conn = sqlsrv_connect($serverName,$infoConnection);
        } catch (Execption $e) {
            die('Connected Failed:'. $e->getMessage());
        }

        $EMPLEADOS = "SELECT COLUMN_NAME AS COLUMNA , DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$EMPLEADOS';";

        $result = sqlsrv_query($conn,$query);
        if(!$result) {
            die('Query Failed'. sqlsrv_error($conn));
        }

        $json = array();
        while($row = sqlsrv_fetch_array($result)) {
            $json[] = array(
            'NombreCampo' => $row["COLUMNA"],
            'TipoCampo' => $row["DATA_TYPE"]
             );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

?>
