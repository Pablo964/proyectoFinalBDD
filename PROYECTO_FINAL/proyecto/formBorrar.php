<html>
<header><meta charset="UTF-8"></header>
<body>
<script>
function confirmar() 
{
  confirm("¿Estás seguro de que deseas borrar la habilidad?");
}
</script>
<form name="formulario" action="borrar.php">
    <h1>Borrar habilidad especial</h1>
    <table>
        <tr>
            <td>
                id:
            </td>
            <td>
                <input type="text" name="id"/>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" name="enviar" value="enviar" onclick="confirmar()"/> 
    <a href="index.html">Volver al menú principal</a>
</form>
</body>
</html>
