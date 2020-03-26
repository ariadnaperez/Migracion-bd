<!DOCTYPE html>
<html>
<head>
	<title> Proyecto </title>
	<link rel="stylesheet" type="text/css" href="./librerias/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./librerias/bootstrap/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="./librerias/bootstrap/js/jquery.min.js"></script>
	<script type="text/javascript" src="./librerias/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/Controlador.js"></script>

</head>
<body>
	

    <div class="col-lg-6 col-md-8 xs-12">
    	
    	
        <button class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal_selector"> Selector </button>
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
        <h4 class="modal-title"> Selector </h4>
      </div>
      <div class="modal-body">
        <p> Seleccion </p>
        <select class="form-control" id="select_tabla" onchange="select_tabla();">
        <option value=""> Seleccione la tabla</option>
            <?php
             require 'conexion.php';
             $sql="SELECT * FROM sys.tables WHERE name != 'sysdiagrams' ORDER BY object_id";
             $stmt = sqlsrv_query( $conn, $sql );
             while ($row= sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
                 $name = $row['name'];
                 $object_id=$row['object_id'];
                 
                 ?>
 
                <option value="<?php echo $name; ?>"> <?php echo $name; ?></option>

             <?php
            }
            sqlsrv_free_stmt($stmt);  

            
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