<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8 charset=ISO-8859-1" /><meta http-equiv="Content-Type" content="text/html; charset=utf-8 charset=ISO-8859-1" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css" />
	<style>
	*{
	 font-family: "Times New Roman";
	}
	  #contenedor{
	  }
	#tit { color:blue; display:inline;}

#cabecera{
  text-align: center;
  border: 2px solid;
  font-size: 2em;
  font-family: Verdana;
  width:100%;
  background-color:#BDB76B;/*#E9967A*/
}
#cabecera td{
background-color:yellow;
}
#cabecera td:hover{
background-color:grey;
}
#menu_cabecera{
	border: 2px solid;
	margin: auto;
	font-size: 1em;
	border-collapse: collapse;
/*	display:inline;
	padding:5px;*/
}
#menu_cabecera td{
	border: 1px solid;
	text-align: center;
	padding: 10px;
}
#introduccion{
  font: 1.2em Verdana, Arial, sans-serif;
  padding-left:35%;
  background-color: LightBlue;
}


	</style>
</head>
<body>

<div id="cabecera">
  <p>Ponente: PABLO GARRAMONE</p>
	<table id="menu_cabecera">
		<tr>
			<td>PROYECTO MUNDIAL</td>
		</tr>
		<tr>
			<td>BUSCADOR DE PARTIDOS </td>
		</tr>
	</table>
	<a href="principal.php"> Volver Atrás </a>
</div>
<div id="introduccion">
<?php

	$conexion = oci_connect('MUNDIAL', '1234', 'localhost/bddinicial');
	$anyomundial = $_REQUEST['p_anyo_mundial'];
	$e_l = $_REQUEST['local'];
	$e_v = $_REQUEST['visitante'];
	$sede = $_REQUEST['estadio'];
	
	
   try
   {
	$stid = oci_parse($conexion, 'call MUNDIAL.busqPartido(:p_anyo_mundial,:p_local,:p_visitante,:p_estadio,:rsPat) into :cantidad');
	$partidos = oci_new_cursor($conexion);
	//$goles = oci_new_cursor($conexion);
	$cantidad=0;
	oci_bind_by_name($stid,":p_anyo_mundial",$anyomundial);
	oci_bind_by_name($stid,":eq_l",$e_l);
	oci_bind_by_name($stid,":eq_v",$e_v);
	oci_bind_by_name($stid,":sede",$sede);	
	oci_bind_by_name($stid,":rsPat",$partidos,-1,OCI_B_CURSOR);
	oci_bind_by_name($stid,":cantidad",$cantidad,1000);	
	//oci_bind_by_name($stid,":rsGoles",$goles,-1,OCI_B_CURSOR);
	oci_execute($stid);
	oci_execute($partidos);
	//oci_execute($goles);
	


  if (!$stid) 
	echo "error";   
 else {

	echo "<table border=1>";
   if ($cantidad<=3)
   {
		while ($fila = oci_fetch_array($partidos, OCI_ASSOC)) 
		{ 
			if ($fila['ORIGEN_DATOS']=="PARTIDO")
			{
				?><tr style="background-color:grey"><td><?php
					echo "<br/>".$fila['C3']. ' - ' .$fila['C1']. ' - ' . $fila['N1']. ' - ' .$fila['C2']. ' - ' .$fila['N2'];
				   ?></td></tr><?php
			}
			else
			{
				if ($fila['C6']!=" ")
				{
					?><tr><td><?php
					echo $fila['C6'];
					echo "<br/>----------------";
				   ?></td></tr><?php
				}
				?><tr><td><?php
				  echo $fila['N3']. '- ' . $fila['C4']. '( '.$fila['N4']. ') '.$fila['C5'];
				?></td></tr><?php
			}
		}
    }
    else if ($cantidad<10)
	{
		//while (($fila = oci_fetch_array($recordSet, OCI_ASSOC)) != false) 
		while ($fila = oci_fetch_array($partidos, OCI_ASSOC)) { 
			if ($fila['ORIGEN_DATOS']=="PARTIDO")
			{
			?><tr style="background-color:grey"><td><?php
				echo $fila['C3']. ' - ' .$fila['C1']. ' - ' . $fila['N1']. ' - ' .$fila['C2']. ' - ' .$fila['N2'];
			   ?></td></tr><?php
			}
			else
			{
			?><tr><td><?php
				echo $fila['N4']. ' - ' . $fila['C6']. ' ('.$fila['C7'].')';
			   ?></td></tr><?php
			}
		}
	}
	else
	{
		while ($fila = oci_fetch_array($partidos, OCI_ASSOC)) { 
			?><tr><td><?php
				echo $fila['FECHA']. ' - ' .$fila['EQUIPO_L']. ' - ' . $fila['RESULTADO_L']. ' - ' .$fila['EQUIPO_V']. ' - ' .$fila['RESULTADO_V'];
			   ?></td></tr><?php		
		}
		
	}
	echo "</table>";
 }
 oci_free_statement($stid);
 oci_close($conexion);

?>
</table>
</div>
</body>
</html>
<?php
   } catch (exception $e) {    print_r($e);}
?>
 

