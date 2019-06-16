<meta charset="UTF-8">
<?php
	if ($_REQUEST['id'] == "") 
	{
		echo "<p style='color:red'>Error el id no puede estar vacio</p>";
		echo"<p><a href='formConsultar.php'>Volver</a></p>";
	}
	else 
	{
		$conn = oci_connect('PARAGON', '1234', 'localhost/BDDINICIAL');

		$cursor = oci_new_cursor($conn);
		$opcion = "CONSULTAR";
		$id = $_REQUEST['id'];
		$vel = "0";
		$cura = "0";
		$danyo = "0";
		$mago = "0";	
		
		$stid = oci_parse($conn, "begin GESTION.MADRE(:cur,'".$opcion."', '".$id."','".$vel."','".$cura."','".$danyo."','".$mago."'); end;");
		oci_bind_by_name($stid, ":cur", $cursor, -1, OCI_B_CURSOR);
        oci_execute($stid);
        oci_execute($cursor);
        echo "<table style='border:1px solid black'>";
        echo "<tr><th>Id habilidad</th><th>P.velocidad</th><th>P.cura</th><th>P.danyo</th><th>Nombre mago</th><th>P.danyo magico</th></tr>";
        while (($row = oci_fetch_array($cursor, OCI_NUM+OCI_RETURN_NULLS)) != false) 
        {
            echo "<tr>";
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1] . "</td>";
            echo "<td>".$row[2] . "</td>";
            echo "<td>".$row[3] . "</td>";
            echo "<td>".$row[4] . "</td>";
            echo "<td>".$row[6] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
		//oci_free_statment($stid);
		oci_close($conn);

		echo"<p><a href='index.html'>Menú</a></p>";
	}
?>