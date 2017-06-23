<?php
session_start();
include('../../global/conecta.php');
include('../../global/libera.php');

$dataHoje 	  = date('d/m/Y');
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

//verificar se a data é de hoje
if($data1 <> $dataHoje){
	?><script type="text/javascript">
		alert('Data Invalida ! NADA SALVO !');
		location.href="../view/form_devolucao.php";
	</script><?php
} else {

	//VERIFICAR NOME DO OPERADOR PARA CONFIRMAR SE A SAIDA É PARA ELE
	if(($oper) or ($oper <> "") or ($oper <> 0)){
		if($linhaNome == 1){
			?>
			<script type="text/javascript">
			if (confirm("Registrando Devolucao de [ <?php echo $qtd ?> ] Sacolas para o Operador [ <?php echo $oper ?> - <?php echo $nome ?> ] - Data <?php echo $data1 ?>")) {
		}else{
			location.href="../view/form_devolucao.php";
		}
			</script>
		<?php
		}else{
			?>
			<script type="text/javascript">
				alert('Operador Nao Existe !');
				<?php $operadorExiste = false; ?>
				location.href="../view/form_devolucao.php";
			</script>
			<?php
		}
	}

	if($operadorExiste == true){
		$data2 = $data[2] . "-" . $data[1] . "-" . $data[0];
		
		//OPERADOR, MOVIMENTO PARA ESTA DATA
		$buscaSaidasOperador 	= mysql_query("select sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where operador = $oper and data = '$data2'");
		$dadosSaidasOperador	= mysql_fetch_array($buscaSaidasOperador);
		$qtdSaidaBanco			= $dadosSaidasOperador[qtdSaidas];
		
		//OPERADOR, MOVIMENTO PARA ESTA DATA
		$buscaDevolucoesOperador 	= mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where operador = $oper and data = '$data2'");
		$dadosDevolucoesOperador 	= mysql_fetch_array($buscaDevolucoesOperador);
		$qtdDevolucaoBanco	 	= $dadosDevolucoesOperador[qtdDevolucoes];
		
		$buscaLinha = mysql_query("select id from Mov_Sacolas_Saida where operador = $oper and data = '$data2'");
		$linha 		= mysql_num_rows($buscaLinha);


		if (  (!(Checkdate($data[1],$data[0], $data[2] ))) ) {
			echo "<script>window.alert('Data Invalida [$data1 /1 - $data], NADA SALVO !'); window.location.replace('../view/form_devolucao.php');</script>"; 
		} else {
			
			$data = $data[2] . "-" . $data[1] . "-" . $data[0];
				
			//OPERADOR COM MOVIMENTO NESTA DATA
			if($linha > 0){
				if ($qtdSaidaBanco >= ($qtd + $qtdDevolucaoBanco)){
					$query = "insert into Mov_Sacolas_Devolucao (operador, data, dataRegistro, horaRegistro, qtdDevolucao, filial, idUsuario)
									   values ($oper, '$data', '$dataRegistro', '$hora', $qtd, '$filial1', $idUsuario)";
					if( mysql_query($query)) {
						echo 
						"<script>window.alert('Salvo com Sucesso !');
							window.location.replace('../view/form_devolucao.php');
						</script>";	
					}
					else {
						echo 
						"<script>window.alert('Algo Errado no Query !');
							window.location.replace('../view/form_devolucao.php');
						</script>";		
					}
					
					
				}else{
					echo 
					"<script>window.alert('Quantidade Devolucao Maior que Total das Saidas ! NADA SALVO ! ');
						window.location.replace('../view/form_devolucao.php');
					</script>";	
				}
			} else {
				//OPERADOR SEM MOVIMENTO NESTA DATA(UPDATE)
				echo 
				"<script>window.alert('Operador Sem Movimento Para Esta Data ! NADA SALVO ! ');
					window.location.replace('../view/form_devolucao.php');
				</script>";	
			}
			
			
			
		}
	}
}
?>