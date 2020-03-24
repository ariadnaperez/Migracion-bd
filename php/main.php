<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<script src="./js/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="./js/Controlador.js"></script>

<form action="./conversion.php" method="get">
  <p>Seleccione una Base de Datos</p>
  <select name="nombreBds" id="nombreBds">
  <option value="default">----</option>
    <?php
      include "./extraer.php";
      $i=0;
      while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ): 
    ?>
    <option value="<?= $i?>"><?= $row['name']?></option>
    <?php 
      $i++; 
      endwhile; 
      sqlsrv_free_stmt( $stmt1);
    ?>
  </select>

  <p>Seleccione una tabla para ver sus campos y tipos de datos</p>
  <select name="nombreTablas" id="nombreTablas">
    <option value="default">----</option>
    <?php
      include "./extraer.php";
      $i=0;
      while( $row = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ): 
    ?>
    <option value="<?= $i?>"><?= $row['name']?></option>
    <?php 
      $i++; 
      endwhile; 
      sqlsrv_free_stmt( $stmt2);
    ?>
  </select>
<!------------------------------------------Extraer Campos--------------------------------------->
<p>Seleccione una tabla para ver sus campos y tipos de datos</p>
  <select name="nombreCampos" id="nombreCampos">
    <option value="default">----</option>
    <?php
      include "./extraer.php";
      $i=0;
      while( $row = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC) ): 
    ?>
    <option value="<?= $i?>"><?= $row['COLUMN_NAME']?></option>
    <?php 
      $i++; 
      endwhile; 
      sqlsrv_free_stmt( $stmt3);
    ?>
     <?php
      include "./extraer.php";
    if(isset($_POST['nombre']) && isset($_POST["tabla"])) {
        $nombreBD = $_POST["Empleados"];
        $nombreTabla = $_POST["EMPLEADOS"];
        $serverName = "localhost";
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

</select>
<!-------------------------------------------------------------------->
		<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#mimodal">
 Ver Tipo de Datos
</button>

<!-- Modal -->
<div class="modal fade" id="mimodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Nombre Columnas Tipos de Datos</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <table class="table">
  <thead>
    <tr>
      
      <th scope="col">Nombre Columnas</th>
      <th scope="col">Tipos de Datos </th>
 </tr>
  </thead>
  <tbody>
  <script var variableJS =Obtener();></script>
<?php
$nombreTabla = “<script document.write(variableJS)></script>”;
echo "nombreTabla = $nombreTabla<br>"
?>
  <?php
      include "./extraer.php";
      $i=0;
      while( $row = sqlsrv_fetch_array( $stmt3, SQLSRV_FETCH_ASSOC)): 
    ?>
    <tr>
      <td><?= $row['COLUMN_NAME']?></td>
      <td><?= $row['DATA_TYPE']?></td>
      </tr>
      <?php
      endwhile; 
      sqlsrv_free_stmt( $stmt3);
      ?>
  </tbody>
</table>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------------------Modal Tipo de Datos------------------------------------------------------->
<title>modal</title>
</head>
<body>
		<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#mimodal">
 Ver Tipo de Datos
</button>

<!-- Modal -->
<div class="modal fade" id="mimodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Tipos de Datos</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
      <table class="table">
  <thead>
    <tr>
      
      <th scope="col">SQL SERVER</th>
      <th scope="col">ORACLE </th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Dato1</td>
      <td>Dato1</td>
    </tr>
    <tr>
      <td>Dato2</td>
      <td>Dato2</td>
      
    </tr>
  
  </tbody>
</table>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Migrar BD</button>
      </div>
    </div>
  </div>
</div>
<!-------------------------------------------------------------------------------------------------------------------------->

</body>
</html>