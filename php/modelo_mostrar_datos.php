
 <table class="table table-condensed">
 <tr>
 <br></br>
		<td ><b> Nombre Campo </b></td>
		<td><b> Tipo de Dato</b></td>
		<td><b>Caracter Maximo</b></td>
	</tr>
 	<?php
		$name = $_POST['name'];

		require './extraer.php';

		while ($row= sqlsrv_fetch_array($stmt4,SQLSRV_FETCH_ASSOC)) {
			$nombreTabla = $row['COLUMN_NAME'];
			$tipoDato = $row['DATA_TYPE'];
			$CaracterMax=$row['CHARACTER_MAXIMUM_LENGTH'];
    ?>
	<tr>
		<td> <?php echo $nombreTabla; ?> </td>
		<td> <?php echo $tipoDato; ?></td>
		<td> <?php echo $CaracterMax; ?></td>

	</tr>
	
	<?php
            }
            sqlsrv_free_stmt($stmt4);  
	?>
</table>
 