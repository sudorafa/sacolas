<?php
session_start();
include('../../global/conecta.php');
include('../../global/libera.php');

$dataRegistro = date('Y-m-d');

$oper		= $_POST["operador"];

$qtd		= $_POST["qtd"];

$data1		= $_POST["data"];
$data		= str_replace('-','/',$data1);
$data 		= explode("/", $data);

$hora 		= date('H:i');

$idUsuario  = $_SESSION["idusuario"];

$servidor = `uname -a | awk -F" " '{print $2}'`;
$filial1  = trim($servidor);

$dadosOperadorNome 	= mysql_query("select nomeOperador from operadoresrec where numOperador = $oper");
$dadosNome		= mysql_fetch_array($dadosOperadorNome);

$nome			= $dadosNome[nomeOperador];
$linhaNome 		= mysql_num_rows($dadosOperadorNome);

$operadorExiste = true;
//VERIFICAR NOME DO OPERADOR PARA CONFIRMAR SE A SAIDA É PARA ELE

if(($oper) or ($oper <> "") or ($oper <> 0)){
	if($linhaNome == 1){
		?>
		<script type="text/javascript">
		if (confirm("Registrando Saida de [ <?php echo $qtd ?> ] Sacolas para o Operador [ <?php echo $oper ?> - <?php echo $nome ?> ] - Data <?php echo $data1 ?>")) {
	}else{
		location.href="../view/form_saidas.php";
	}
		</script>
	<?php
	}else{
		?>
		<script type="text/javascript">
			alert('Operador Nao Existe !');
			<?php $operadorExiste = false; ?>
			location.href="../view/form_saidas.php";
		</script>
		<?php
	}
}

if($operadorExiste == true){
	//VERIFICAR SE OPERADOR TEM MOVIMENTO PARA ESTA DATA
	
	$data2 = $data[2] . "-" . $data[1] . "-" . $data[0];

	$dadosOperador 	= mysql_query("select operador from Mov_Sacolas_Saida where operador = $oper and data = '$data2'");
	$linha 			= mysql_num_rows($dadosOperador);


	if (  (!(Checkdate($data[1],$data[0], $data[2] ))) ) {
		echo "<script>window.alert('Data Invalida [$data1 /1 - $data], NADA SALVO !'); window.location.replace('../view/form_saidas.php');</script>"; 
	} else {
		
		$data = $data[2] . "-" . $data[1] . "-" . $data[0];
			
		//OPERADOR SEM MOVIMENTO NESTA DATA(INSERT)
		$query = "insert into Mov_Sacolas_Saida (operador, data, dataRegistro, horaRegistro, qtdSaida, filial, idUsuario)
								   values ($oper, '$data', '$dataRegistro', '$hora', $qtd, '$filial1', $idUsuario)";
				
		if( mysql_query($query)) {
			echo 
			"<script>window.alert('Salvo com Sucesso !');
				window.location.replace('../view/form_saidas.php');
			</script>";	
		}
		else {
			echo 
			"<script>window.alert('Algo Errado no Query ! $idUsuario');
				window.location.replace('../view/form_saidas.php');
			</script>";		
		}
		
	}
}
?>