<?php   /* Versión Funciones */   

function conectar($bd)
{
	if(!(@$idCone=mysqli_connect("localhost","root","", $bd))) 
		die("Error de conexión ".mysqli_connect_errno()." Motivo: " .mysqli_connect_error());   
	//echo "Conexión realizada con éxito ".mysqli_get_server_info($idCone); 	
	
	return $idCone;
}

function cambiarBD($conexion, $bd)
{
	mysqli_select_db($conexion,$bd);
	
}

conectar('prueba');

?>