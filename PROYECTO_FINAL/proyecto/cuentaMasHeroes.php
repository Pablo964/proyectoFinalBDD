<meta charset="UTF-8">
<?php

	
    $conn = oci_connect('PARAGON', '1234', 'localhost/BDDINICIAL');

    try
    {
        $stid = oci_parse($conn, "begin ESTADISTICAS.CUENTA_MAS_HEROES(:nombre, :cantidadHeroes, :amigos); end;");

        oci_bind_by_name($stid, ":nombre", $nombre, 50);
		oci_bind_by_name($stid,":cantidadHeroes", $cantidadHeroes, 50);
		oci_bind_by_name($stid,":amigos", $amigos, 50);        
        oci_execute($stid);
        
        echo "<p>La cuenta con más héroes es: $nombre  con $cantidadHeroes heroes <br> Esta cuenta tiene $amigos amigos</p>";
        oci_free_statement($stid);
        oci_close($conn);
    }
    catch(exception $e)
    {
        echo $e;
    }
    echo"<p><a href='index.html'>Menú principal</a></p>";
	
?>