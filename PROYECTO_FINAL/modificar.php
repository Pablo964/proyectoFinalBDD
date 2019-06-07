<?php

	include("conectar.php");
    $idCone=conectar("prueba");

    if (isset($_REQUEST['enviarMod'])) 
    {
        if ($_REQUEST['nombreMod'] == "") 
        {
            echo"ERROR: El nombre del alumno no puede estar vacío";
            
        }
        else 
        {
            $sentenciaUpdate="UPDATE ALUMNOS
                            SET nombre = '".$_REQUEST['nombreMod']."',
                            direccion = '".$_REQUEST['direccionMod']."',
                            email = '".$_REQUEST['emailMod']."',
                            telefono = '".$_REQUEST['telefonoMod']."'
                            WHERE nombre='".$_REQUEST['nombreOrig']."'";

            $result=mysqli_query($idCone,$sentenciaUpdate);

            echo"Se ha modificado al alumno <b>"
                    .$_REQUEST['nombreOrig']."</b> correctamente";  
        }
        echo"<p><a href='index.html'>Volver</a></p>";  
    }
    else 
    {
        if ($_REQUEST['nombre'] == "") 
	    {
            echo "<p style='color:red'>Error el nombre no puede estar vacio</p>";
            echo"<p><a href='formInsertar.php'>Volver</a></p>";
	    }
        else 
        {
            $sentenciaSQL="SELECT *  
                            FROM ALUMNOS 
                            WHERE NOMBRE = '".$_REQUEST['nombre']."'";
            
            $result=mysqli_query($idCone,$sentenciaSQL);
            $campos = mysqli_fetch_array($result,  MYSQLI_ASSOC);
            
            if(mysqli_affected_rows($idCone) == 0)
            {
                print"<p style='color:red'>ERROR NO HAY NINGÚN ALUMNO CON 
                    ESE NOMBRE</p>";
            }    
            else
            {
                
                echo"
                    <h1>MODIFICAR ALUMNO ".$_REQUEST['nombre']."</h1>
                    <form action'".$_SERVER['PHP_SELF']."'>
                        <table>
                            <tr>
                                <td>Nombre</td>
                                <td><input type='text' name='nombreMod'
                                    value='".$campos['nombre']."'/></td>
                            </tr>
                            <tr>
                                <td>Dirección</td>
                                <td><input type='text' name='direccionMod'
                                    value='".$campos['direccion']."'</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><input type='text' name='emailMod'
                                    value='".$campos['email']."'</td>
                            </tr>
                            <tr>
                                <td>Teléfono</td>
                                <td><input type='text'name='telefonoMod'
                                    value='".$campos['telefono']."'</td>
                                <input type='hidden' name='nombreOrig'
                                    value='".$campos['nombre']."'/>
                            </tr>
                            <tr>
                                <td><input type='submit' value='enviar'
                                    name='enviarMod'</td>
                            </tr>
                        </table>
                    </form>";
                    //poner input type hidden con el nombre original
                    //para enviarlo también con el formulario y no perderlo
            }
            echo"<p><a href='index.html'>Volver</a></p>";
        }
    }
	
	mysqli_close($idCone);
?>