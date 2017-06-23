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
	
	$dataHoje = date('d/m/Y');
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.form_avaria.qtd.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
		function Formatadata(Campo, teclapres)
		{
			var tecla = teclapres.keyCode;
			var vr = new String(Campo.value);
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			vr = vr.replace("/", "");
			tam = vr.length + 1;
			if (tecla != 8 && tecla != 8)
			{
				if (tam > 0 && tam < 2)
					Campo.value = vr.substr(0, 2) ;
				if (tam > 2 && tam < 4)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2);
				if (tam > 4 && tam < 7)
					Campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 7);
			}
		}
	</script>
	<!---------------------------------------------------------------------------------->
	<script language="javascript">
	<!-- chama a função (cadastro) -->
	function valida_dados_avaria (form_avaria)
	{
		if (form_avaria.qtd.value=="")
		{
			alert ("Por favor informe a quantidade.");
			form_avaria.qtd.focus();
			return false;
		}	
	return true;
	}
	</script>
	<!---------------------------------------------------------------------------------->
	<!---------------------------------------------------------------------------------->
	<script language="javascript">
	<!-- chama a função (cadastro) -->
	function valida_dados_lista (form_lista_avaria)
	{
		if (form_lista_avaria.dataInicial.value=="")
		{
			alert ("Por favor digite a data inicial.");
			form_lista_avaria.dataInicial.focus();
			return false;
		}
		if (form_lista_avaria.dataFinal.value=="")
		{
			alert ("Por favor digite a data final.");
			form_lista_avaria.dataFinal.focus();
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
					<h2 align="center"> <font color="purple"> AVARIA </font></h2> 
					<br/> 
					<table cellpadding="0" border="1" width="80%" align="center">
					<tr>
						<form action="../controller/query_avaria.php" method="post" name="form_avaria" align="center" onSubmit="return valida_dados_avaria(this)">
						<td class="corpo"align="center" width="40%"> 
							<br/>	
							<label> <font color="336699">  Registrar Sacolas Avariadas</label> &nbsp;
							<br/> <br/>
							
							<label> <font color="336699"> Quantidade: </label> &nbsp;
							<input name="qtd" type="text" size="2" maxlength="2" onkeyup='if (isNaN(this.value)) {this.value = ""}'> &nbsp;
									
							<input type="submit" name="ok" value="ok"> &nbsp; &nbsp; &nbsp;
							<br/> <br/>
							<br/> 
						</td>
						</form>
						<td/>
						<form action="form_avaria.php" method="post" name="form_lista_avaria" align="center" onSubmit="return valida_dados_lista(this)">
						<td class="corpo" align="center">
							<br/>
							<label> <font color="336699">  Listar Sacolas Avariadas</label> &nbsp;
							<br/> <br/>
							
							<label> <font color="336699">  Data Inicial: </label> &nbsp;
							<input type="text" name="dataInicial" value="<?php echo $dataHoje?>" size="10" maxlength="10" onkeyup="Formatadata(this,event)" />&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;
							
							<label> <font color="336699">  Data Final: </label> &nbsp;
							<input type="text" name="dataFinal" value="<?php echo $dataHoje?>" size="10" maxlength="10" onkeyup="Formatadata(this,event)" />&nbsp; &nbsp; &nbsp;
							<input type="submit" name="listar" value="listar"> &nbsp; &nbsp; &nbsp;
							<br/> <br/>
							<br/> 
						</td>
						</form>
					</tr>
					</table> 

					<?php 
							
							$dataInicial1 	= $_POST['dataInicial'];
							$dataInicial = explode('/', $dataInicial1);
							$dataInicial = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];
							
							$dataFinal1	 	= $_POST['dataFinal'];		
							$dataFinal = explode('/', $dataFinal1);
							$dataFinal = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];
							
							$consulta = mysql_query("select id from Avaria_Sacola where data between '$dataInicial' and '$dataFinal'");
							$linha = mysql_num_rows($consulta);
					 
							
							
							if(($_POST[dataInicial]) or ($_POST[dataInicial] <> "") or ($_POST[dataInicial] <> 0)){
								
								if($linha > 0)
								{
									//  existe;
									?> <br/><br/> <?php
									include("form_listar_relatorio_avaria.php");
								}
								else
								{
									// não existe;
									echo 
									"<script>window.alert('Sem dados para essa data !')
										
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