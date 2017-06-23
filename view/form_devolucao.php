<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - Aux. Informática
	Filial 47, Recife, 29 de Setembro de 2016
	*/
	include('../../global/libera.php');
	include('../../global/conecta.php');
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
	<body onLoad="document.form_saidas.operador.focus()"> 
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
	function valida_dados (form_saidas)
	{
		if (form_saidas.data.value=="")
		{
			alert ("Por favor digite a data.");
			form_saidas.data.focus();
			return false;
		}	
		if (form_saidas.operador.value=="")
		{
			alert ("Por favor informe o numero do operador.");
			form_saidas.operador.focus();
			return false;
		}	
		if (form_saidas.qtd.value=="")
		{
			alert ("Por favor informe a quantidade.");
			form_saidas.qtd.focus();
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
					<h2 align="center"> <font color="red"> DEVOLUÇÃO </font></h2> 
					<br/>
					<table cellpadding="0" border="1" width="80%" align="center">
					<tr>
						<form action="../controller/query_devolucao.php" method="post" name="form_saidas" align="center" onSubmit="return valida_dados(this)">
						<td	class="corpo" align="center" width="60%"> 
							<br/>
							<label> <font color="336699">  Registrar Devolução das Sacolas </label> &nbsp;
							<br/> <br/>
							
							<label> <font color="336699">  Digite a Data: </label> &nbsp;
							<input type="text" name="data" value="<?php echo $dataHoje?>" size="10" maxlength="10" onkeyup="Formatadata(this,event)" />&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;
									
							<label> <font color="336699"> Operador: </label> &nbsp;
							<input name="operador" type="text" size="4" maxlength="4" onkeyup='if (isNaN(this.value)) {this.value = ""}'> &nbsp;
							
							<label> <font color="336699"> Quantidade: </label> &nbsp;
							<input name="qtd" type="text" size="2" maxlength="2" onkeyup='if (isNaN(this.value)) {this.value = ""}'> &nbsp;
									
							<input type="submit" name="ok" value="ok"> &nbsp; &nbsp; &nbsp;
							<br/> <br/>
							<br/>
						</td>
						</form>
					</tr>
					</table> 
				</div>
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>