<form action="extraer.php" method="get">
    <p>Bases de Datos Existentes: </p>
    
<select name="ad" onchange="salta(this.form)">
    <option selected> Seleccione una Base de Datos
    <option value="xxxx.htm">texto 1
    <option value="yyyy.htm">texto 2
    <option value="zzzz.htm">texto 3
</select>
 <br></br>
 <p>Tablas existentes en la Base de Datos</p>

<select name="ad" onchange="salta(this.form)">
    <option selected> Seleccione una Tabla para visulizar las columnas 
    <option value="xxxx.htm">texto 1
    <option value="yyyy.htm">texto 2
    <option value="zzzz.htm">texto 3
</select>

<br></br>

   <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<br></br>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Migrar Base de Datos</button>

   <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Modal Header</h4>
  </div>
  <div class="modal-body">
    <p>Some text in the modal.</p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>


  </form>