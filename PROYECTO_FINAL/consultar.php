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
        while (($row = oci_fetch_array($cursor, OCI_NUM+OCI_RETURN_NULLS)) != false) 
        {
            echo $row[0] . "<br />\n";
            echo $row[1] . "<br />\n";
            echo $row[2] . "<br />\n";
            echo $row[3] . "<br />\n";
            echo $row[4] . "<br />\n";
            echo $row[6] . "<br />\n";
        }
		//oci_free_statment($stid);
		oci_close($conn);

		echo"<p><a href='index.html'>Menú</a></p>";
	}
?>