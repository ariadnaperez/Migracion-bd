
 <table class="table table-condensed">
 <tr>
 <br></br>
		<td align="center" ><b> Nombre Campo </b></td>
		<td align="center"><b> Tipo de Dato</b></td>
		<td  align="center"><b>Caracter Maximo</b></td>
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
		<td align="center"> <?php echo $nombreTabla; ?> </td>
		<td  align="center"> <?php echo $tipoDato; ?></td>
		<td align="center"> <?php echo $CaracterMax; ?></td>

	</tr>
	
	<?php
            }
            sqlsrv_free_stmt($stmt4);  
	?>
</table>
 