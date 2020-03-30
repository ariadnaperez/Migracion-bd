<!DOCTYPE html>
<html>
<head>
	<title> Proyecto </title>
	<link rel="stylesheet" type="text/css" href="./Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./Bootstrap/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="./Bootstrap/js2/jquery.min.js"></script>
	<script type="text/javascript" src="./Bootstrap/js2/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/Controlador.js"></script>

</head>
<body>
	
<p>Seleccione una Base de Datos</p>
  <select class="form-control" name="nombreBds" id="nombreBds" onchange="nombreBds();">
  <option value="default">----</option>
    <?php
      include "./extraer.php";
      $i=0;
      while( $row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC) ){
        $name = $row['name']; 
    ?>
    <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
    <?php 
     }
      sqlsrv_free_stmt( $stmt1);
    ?>
  </select>
  <br></br>

  
    <div >
        <button class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal_selector" id="btn-tablas"> Tablas de la BD </button>
    	<div id="panel_listado">
    		<!-- Panel de datos -->

    	</div>
    </div>
	</div>

</body>
</html>

<!-- Modal -->
<div id="myModal_selector" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #084B8A; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Seleccione una Tabla </h4>
      </div>
      <div class="modal-body">
        <p> Seleccione una tabla para visualizar sus campos y tipos de datos </p>
        <select class="form-control" id="select_tabla" onchange="select_tabla();">
        <option value=""> Seleccione la tabla</option>
            <?php
             require 'extraer.php';
             while ($row= sqlsrv_fetch_array($stmt3,SQLSRV_FETCH_ASSOC)) {
                 $name = $row['name'];
                 ?>
                <option value="<?php echo $name; ?>"> <?php echo $name; ?></option>
            <?php
              }
              sqlsrv_free_stmt($stmt3);   
            ?>
        </select>
        <div id="panel_selector"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cerrar </button>
      </div>
    </div>
  </div>
</div>