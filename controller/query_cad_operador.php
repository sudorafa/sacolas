<?php
session_start();
include('../../global/conecta.php');
include('../../global/libera.php');

$operador	= $_POST["operador"];
$nome		= $_POST["nome"];

$servidor 	= `uname -a | awk -F" " '{print $2}'`;
$filial1  	= trim($servidor);

$idUsuario  = $_SESSION["idusuario"];

	$query = "insert into operadoresrec (numOperador, nomeOperador, filial)
			   values ($operador, '$nome', '$filial1')";
	if( mysql_query($query)) {
		echo 
		"<script>window.alert('Salvo com Sucesso !');
			window.location.replace('../view/form_upar.php');
		</script>";	
	}else {
		echo 
		"<script>window.alert('Algo Errado no Query !');
			window.location.replace('../view/form_upar.php');
		</script>";		
	}
?>