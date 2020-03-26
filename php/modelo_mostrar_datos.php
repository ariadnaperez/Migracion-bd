
 
 <table class="table table-condensed">
 <tr>
 <br></br>
		<td ><b> Nombre Campo </b></td>
		<td><b> Tipo de Dato</b></td>
	</tr>
 <?php
//echo "immpresion = ";
 $name = $_POST['name'];

 require './conexion.php';

$sql="SELECT COLUMN_NAME,DATA_TYPE FROM Information_Schema.Columns WHERE TABLE_NAME='$name'";

$stmt = sqlsrv_query( $conn, $sql );

 while ($row= sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)) {
	$nombreTabla = $row['COLUMN_NAME'];
	$tipoDato = $row['DATA_TYPE'];
                 
                 ?>
	<tr>
		<td> <?php echo $nombreTabla; ?> </td>
		<td> <?php echo $tipoDato; ?></td>
	</tr>
	
	<?php
            }
            sqlsrv_free_stmt($stmt);  


?>
</table>

 