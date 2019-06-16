<meta charset="UTF-8">
<?php
	if ($_REQUEST['nombre'] == "") 
	{
		echo "<p style='color:red'>Error el id no puede estar vacio</p>";
		echo"<p><a href='mostrarDetalles.php'>Volver</a></p>";
	}
	else 
	{
		$coincidencias = false;
		$conn = oci_connect('PARAGON', '1234', 'localhost/BDDINICIAL');
		$cursor = oci_new_cursor($conn);

		$email = $_REQUEST['nombre'];
		$nivel = $_REQUEST['nvl'];
		$danyo = $_REQUEST['danyo'];
		$velocidad = $_REQUEST['vel'];
		$tamanyo = 0;
		$arr = array();

		if($nivel == null)
		{
			$nivel = 0;
		}
		if($danyo == null)
		{
			$danyo = 0;
		}
		if($velocidad == null)
		{
			$velocidad = 0;
		}

		echo "<br>";
		try
		{
			$stid = oci_parse($conn, "begin ESTADISTICAS.BUSCAR(:cur,'".$email."',".$nivel.",".$danyo.",".$velocidad."); end;");
			oci_bind_by_name($stid, ":cur", $cursor, -1, OCI_B_CURSOR);

			oci_execute($stid);
			oci_execute($cursor);
			
			echo "<h2>Héroes de $email</h2>";

			echo "<table border='2'><tr><td>nombre</td><td>nivel</td><td>daño</td><td>velocidad</td></tr>";
			while (($row = oci_fetch_array($cursor, OCI_NUM+OCI_RETURN_NULLS)) != false) 
			{
				echo "<tr>";
				echo "<td>$row[0]</td>";
				echo "<td>$row[1]</td>";
				echo "<td>$row[2]</td>";
				echo "<td>$row[3]</td>";
				$arr[]=$row[4];
				$arr[]=$row[5];
				$arr[]=$row[0];
				echo "</tr>";
				$coincidencias = true;
			}
			echo "</table>";

			$tamanyo = sizeof($arr);

			if($tamanyo > 0)
			{
				echo "<h3>Cartas y gemas recomendadas ";
				echo "<br><table border='2'><tr><td>código gema</td><td>nombre carta</td><td>héroe</td></tr>";
				for ($i=0; $i < sizeof($arr)-2; $i=$i+3)
				{
					echo "<tr>";
					echo "<td>$arr[$i]</td>";
					echo "<td>".$arr[$i + 1]."</td>";
					echo "<td>".$arr[$i + 2]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}

			if(!$coincidencias)
				echo "No hay coincidencias";
			
			oci_close($conn);
		}
		catch(exception $e)
		{
			echo $e;
		}
        echo"<p><a href='index.html'>Menú principal</a> <a href='formBuscar.php'>Volver a buscar</a></p>";
	}
?>