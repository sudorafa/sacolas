<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - Aux. Informática
	Filial 47, Recife, 29 de Setembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	include('../cabecalho.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	
	$anoVi	= 	date('Y');
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.form_estatistica_operadores_mes.ano.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
	<!-- chama a função (cadastro) -->
	function valida_dados (form_relatorio_mes)
	{
		if (form_relatorio_mes.ano.value=="")
		{
			alert ("Por favor digite o ano.");
			form_relatorio_mes.ano.focus();
			return false;
		}
		if (form_relatorio_mes.mes.value==0)
		{
			alert ("Por favor escolha o mes para listar.");
			form_relatorio_mes.mes.focus();
			return false;
		}	
	return true;
	}
	</script>
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> ESTATISTICAS MENSAL </font></h2> 
					<br/>
					<table cellpadding="0" border="1" width="80%" align="center">
					<tr>
						<form action="form_relatorio_mes.php" method="post" name="form_relatorio_mes" align="center" onSubmit="return valida_dados(this)">
						<td	class="corpo" align="center" width="60%"> 
							<br/>
							<label> <font color="336699">  Listar Estatisticas do Mes: </label> &nbsp;
							<br/> <br/>
							<label> <font color="336699">  Mes: </label> &nbsp;
							<select size="1" name="mes">
								<option value="<?php echo $_POST[mes]?>"><?php echo $_POST[mes]?></option>
								<option value="0">--</option>
								<option value="Janeiro">Janeiro</option>
								<option value="Fevereiro">Fevereiro</option>
								<option value="Marco">Marco</option>
								<option value="Abril">Abril</option>
								<option value="Maio">Maio</option>
								<option value="Junho">Junho</option>
								<option value="Julho">Julho</option>
								<option value="Agosto">Agosto</option>
								<option value="Setembro">Setembro</option>
								<option value="Outubro">Outubro</option>
								<option value="Novembro">Novembro</option>
								<option value="Dezembro">Dezembro</option>
							</select> &nbsp; &nbsp;
							
							<label> <font color="336699"> Ano: </label> &nbsp;
							<input name="ano" value="<?php echo $anoVi ?>" type="text" size="4" maxlength="4" onkeyup='if (isNaN(this.value)) {this.value = ""}'> &nbsp;
									
							<input type="submit" name="listar" value="listar"> &nbsp; &nbsp; &nbsp;
							<br/> <br/>
							<br/>
						</td>
						</form>
					</tr>
					</table> 
						
						<?php
							
						
						$ano	= $_POST["ano"];
						$mes	= $_POST["mes"];
						
						$meses = Array(
							'Janeiro' => '01',
							'Fevereiro' => '02',
							'Marco' => '03',
							'Abril' => '04',
							'Maio' => '05',
							'Junho' => '06',
							'Julho' => '07',
							'Agosto' => '08',
							'Setembro' => '09',
							'Outubro' => '10',
							'Novembro' => '11',
							'Dezembro' => '12'
						);
						
						$mes = $meses[$mes];
						
						$dataInicial	=	$ano."-".$mes."-01";
						$dataFinal		=	$ano."-".$mes."-31";
					 
						$consulta = mysql_query("select * from Mov_Sacolas_Saida where data between '$dataInicial' and '$dataFinal'");
						$linha = mysql_num_rows($consulta);
							
							
							if(($_POST[ano]) or ($_POST[ano] <> "") or ($_POST[ano] <> 0)){
								
								
								if($linha > 0)
								{
									//  existe;
									/*?><h5 align="center"> <a href="form_listar_relatorio_mes.php?mes=<?php echo $_POST[mes]?>&ano=<?php echo $_POST[ano]?>&imp=sim"target="_blank">visualizar impressao</a></h5> <?php*/
									include("form_listar_relatorio_mes.php");
								}
								else
								{
									// não existe;
									echo 
									"<script>window.alert('Sem dados para este mes !')
										
									</script>";	
									?> <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/> <?php
								}
							}else{
								?> <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/> <?php
							}
						

						?>
				</div>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>