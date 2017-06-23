<?php
session_start();
include('../../global/conecta.php');
include('../../global/libera.php');

$qtd	= $_POST["qtd"];

$data	= date('Y-m-d');
$hora	= date('H:i');

$servidor = `uname -a | awk -F" " '{print $2}'`;
$filial1  = trim($servidor);

$idUsuario  = $_SESSION["idusuario"];

	$query = "insert into Avaria_Sacola (qtd, data, hora, filial, idUsuario)
			   values ($qtd, '$data', '$hora', '$filial1', $idUsuario)";
	if( mysql_query($query)) {
		echo 
		"<script>window.alert('Salvo com Sucesso !');
			window.location.replace('../view/form_avaria.php');
		</script>";	
	}else {
		echo 
		"<script>window.alert('Algo Errado no Query !');
			window.location.replace('../view/form_avaria.php');
		</script>";		
	}
?>