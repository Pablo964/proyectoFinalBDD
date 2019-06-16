<meta charset="UTF-8">
<?php

    $conn = oci_connect('PARAGON', '1234', 'localhost/BDDINICIAL');

    try
    {
        $stid = oci_parse($conn, "begin ESTADISTICAS.HEROE_MAS_PODEROSO(:nombre, :nivel, :danyo, :velocidad, :poder); end;");

        oci_bind_by_name($stid, ":nombre", $nombre, 50);
		oci_bind_by_name($stid,":nivel", $nivel, 50);
        oci_bind_by_name($stid,":danyo", $danyo, 50);
		oci_bind_by_name($stid,":velocidad", $velocidad, 50);        
		oci_bind_by_name($stid,":poder", $poder, 50);        
                
        oci_execute($stid);
        
        echo "<p>El héroe con más poder es $nombre con nivel $nivel, daño $danyo y velocidad $velocidad. Con un poder total de $poder</p>";
        oci_free_statement($stid);
        oci_close($conn);
    }
    catch(exception $e)
    {
        echo $e;
    }
    echo"<p><a href='index.html'>Menú principal</a></p>";
	
?>