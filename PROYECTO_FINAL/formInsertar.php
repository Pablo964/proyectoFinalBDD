<html>
<header>
	<meta charset="UTF-8">
</header>
<body>
<form name="formulario" action="insertar.php">
    <h1>Insertar habilidad especial</h1>
    <table>
        <tr>
            <td>
                Id:
            <td>
            <td>
                <input type="text", name="id"/>
            <td>
        </tr>
        <tr>
            <td>
                velocidad:
            <td>
            <td>
                <input type="text", name="velocidad" />
            <td>
        </tr>
        <tr>
            <td>
                cura:
            <td>
            <td>
                <input type="text", name="cura" />
            <td>
        </tr>
        <tr>
            <td>
                daño:
            <td>
            <td>
                <input type="text", name="danyo" />
            <td>
        </tr>
        <tr>
            <td>
                nombre mago:
            </td>
            <td>
            <?php
                $conn = oci_connect('PARAGON', '1234', 'localhost/BDDINICIAL');

                $stid = oci_parse($conn, 'SELECT NOMBRE_HEROE_MAGO FROM MAGOS');
                oci_execute($stid);
                
                echo "<select name ='heroe'>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                    foreach ($row as $item) {
                        echo "<option value=". ($item !== null ? htmlentities($item, ENT_QUOTES) : "") .">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</option>\n";
                    }
                
                }
                echo "</select>\n";
                oci_free_statement($stid);
                oci_close($conn);
            ?>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" name="enviar" value="insertar"/> 
    <a href="index.html">Volver al menú principal</a>
</form>
</body>
</html>
