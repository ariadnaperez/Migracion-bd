<!DOCTYPE html>
<html>
<head>
<title>Migración Base de Datos</title>
<link rel="shortcut icon" type="image/png" href="./img/favicon.png"/>
<link rel="stylesheet" type="text/css" href="./css/estilos.css">

	<link rel="stylesheet" type="text/css" href="./Bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./Bootstrap/css/bootstrap-theme.min.css">
	<script type="text/javascript" src="./Bootstrap/js2/jquery.min.js"></script>
  <script type="text/javascript" src="./Bootstrap/js2/bootstrap.min.js"></script>
  <script type="text/javascript" src="./js/Controlador.js"></script>
  <link rel="stylesheet" type="text/css" href="sweetalert/sweetalert2.min.css">
<script type="text/javascript" src="sweetalert/sweetalert2.min.js" ></script>

</head>
<body style = "background-color: #f0d9af" onload="ocultar()">

<script>
    function ocultar() {
          document.getElementById('btn-tablas').style.display = 'none';
          document.getElementById('btn-conversion').style.display = 'none';
          document.getElementById('btn-MIGRACION').style.display = 'none';
    }
</script>

<div class="container" id="div-form">
<h1 style="text-align: center;" class="display-4">Migracion Base de Datos</h1>
<br><br>

<i><p style="text-align: left; font-size:16px;">Bases de Datos </p></i>
  <select class="form-control" name="nombreBds" id="nombreBds" onchange="nombreBds();">
  <option value="default">Seleccione una Base de Datos</option>
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
        <button class="btn btn-info btn-md" data-toggle="modal" data-target="#myModal_conversion" id="btn-conversion"> Conversion de Datos</button>
        <button class="btn btn-info btn-md"  id="btn-MIGRACION" > Migrar BD </button>

<script type="text/javascript">
  $(document).ready(function(){
$("#btn-MIGRACION").click(function(){
  swal({
    title:'Migracion Exitosa',
    text:"La base de Datos se Migro exitosamente",
    type:'success',
    timer: 20000
    
  }).then(function () {
    hacer_click();
    })
  window.location.href="conversion.php";
})
  })
</script>

    <script type="text/javascript">
    function hacer_click()
    {
       
      self.location.reload();
    }
    </script>

      
  

      <div id="panel_listado">
    	</div>
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
             require './extraer.php';
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


<!-- Modal -->
<div id="myModal_conversion" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background-color: #084B8A; color:white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Conversion de los tipos de datos de SQL Server a Oracle </h4>
      </div>
      <div class="modal-body">
        <p> Tipos de datos de SQL Server a Oracle </p>

        <table class="table table-condensed">
 <tr>
 <br></br>
		<td ><b>Tipo de Dato SQL Server </b></td>
		<td><b> Tipo de Dato Oracle</b></td>
	</tr>
	<tr>
		<td> INT </td>
		<td>NUMBER(10) </td>
	</tr>
	<tr>
		<td> VARCHAR </td>
		<td>VARCHAR2 </td>
	</tr>
  <tr>
		<td>MONEY  </td>
		<td>NUMBER(19,4) </td>
	</tr>
  <tr>
		<td> DATETIME </td>
		<td> DATE</td>
	</tr>
</table> 
        <div id="panel_selector"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cerrar </button>
      </div>
    </div>
  </div>
</div>