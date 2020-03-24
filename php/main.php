<html>
<head>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/estilos.css">
<script src="jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<title>modal</title>
</head>
<body style = "background-color: #f0d9af">

  <div class="container" id="div-form">
    <form action="./conversion.php" method="get" id="form-1">
      <div class="form-group container" id="form-3">
        <p style="text-align: center;">Seleccione una Base de Datos</p>
        <br>
        <div class="container" id="select-bds">
          <select name="nombreBds" id="nombreBds" id="select-1">
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
        </div>
      </div>
          <br><br><br><br>
      <div class="form-group container" id="form-3">
        <p style="text-align: center;">Seleccione una tabla para ver sus campos y tipos de datos</p>
        <br>
        <div class="container" id="select-tables">
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
        </div>  
      </div>
    </form>
    <br><br>

      <!------------------------------------------Modal Tipo de Datos------------------------------------------------------->

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
  </div>





</body>
</html>