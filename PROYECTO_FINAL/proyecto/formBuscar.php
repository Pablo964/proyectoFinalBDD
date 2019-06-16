<html>
<header>
	<meta charset="UTF-8">
</header>
<body>
<form name="formulario" action="buscar.php">
    <h1>Buscar héroes de cuenta</h1>
    <p>El valor introducido se filtrará como mínimo</p>
    <table>
        <tr>
            <?php
                $conn = oci_connect('PARAGON', '1234', 'localhost/BDDINICIAL');

                $stid = oci_parse($conn, 'SELECT EMAIL FROM CUENTA');
                oci_execute($stid);
                echo "Cuenta:  <select name ='nombre'>\n";
                while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) 
                {
                    foreach ($row as $item) 
                    {
                        echo "<option value=". ($item !== null ? htmlentities($item, ENT_QUOTES) : "") .">" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "") . "</option>\n";
                    }
                }
                echo "</select>\n";
                oci_free_statement($stid);
            ?>
            </td>
        </tr>
        <tr>
            <td>Nivel: <input type="number" name="nvl"></td>
        </tr>
        <tr>
            <td>Daño: <input type="number" name="danyo"></td>
        </tr>
        <tr>
            <td>Velocidad: <input type="number" name="vel"></td>
        </tr>
    </table>
    <br>
    <input type="submit" name="enviar" value="buscar"/> 
    <a href="index.html">Volver al menú principal</a>
</form>
</body>
</html>
