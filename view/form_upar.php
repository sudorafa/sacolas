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
	
	$perfil = $_SESSION["perfil"];
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body onLoad="document.cad_operador.operador.focus()"> 
	<!-- --------------------------------------------------------------------------------------- -->
	<script type="text/javascript">
        $(document).ready(function($){
          $(function(){
              $('.mask-data').mask('99/99/9999');
          });
        })
	</script>
	<!-- --------------------------------------------------------------------------------------- -->
	<script language="javascript">
	<!-- chama a função (cadastro) -->
	function valida_dados (cad_operador)
	{
		if (cad_operador.operador.value=="")
		{
			alert ("Por favor informe o numero do operador.");
			cad_operador.operador.focus();
			return false;
		}	
		if (cad_operador.nome.value=="")
		{
			alert ("Por favor informe o nome do operador.");
			cad_operador.nome.focus();
			return false;
		}	
	return true;
	}
	</script>
	<!---------------------------------------------------------------------------------->
		<div id="interface">
			<?php include('../menu.php'); ?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Gerenciamento do Sistema  </font></h2> 
					<br/> <br/> 
					<hr width="90%">
					<br/>
					<?php if ($perfil == "CPD" or $perfil == "GERENCIA"){ ?>
					<table cellpadding="0" border="0" width="80%" align="center">
					<tr align="center">
					<td>
					<form action="../controller/query_sas03.php"  name="upar_sas58" method="post" enctype="multipart/form-data">
						<fieldset><legend align="center">Importar csv do sasoi03</legend>
							<input class="arq" type="file" name="arq_csv" /> &nbsp; &nbsp;
							<!--
							<label class="lbl">Informe a Data do Movimento: </label> &nbsp;
							<input type="text" name="data"  size=10 maxlength=10 class="mask-data" />
							-->
							<input type="submit" value="Importar para o BD"/>
							<br/>
						</fieldset>
					</form>
					</td>
					</tr>
					</table>
					<br/>
					<hr width="90%">
					<br/><br/>
				<?php } ?>
				<?php if ($perfil == "CPD"){ ?>
					<table cellpadding="0" border="0" width="80%" align="center">
					<tr align="center">
					<td>
					<form action="../controller/query_operadores.php"  name="upar_operadores" method="post" enctype="multipart/form-data">
						<fieldset><legend align="center">Atualizar Operadores</legend>
							<input class="arq" type="file" name="arq_txt" /> &nbsp; &nbsp;
							<input type="submit" value="Importar para o BD"/>
							<br/>
						</fieldset>
					</form>
					</td>
					</tr>
					</table>
					<br/>
					<hr width="90%">
					<br/><br/>
				<?php } ?>
				<?php if ($perfil <> "LOJA"){ ?>
					<table cellpadding="0" border="0" width="80%" align="center">
					<tr align="center">
					<td>
					<form action="../controller/query_cad_operador.php" method="post" name="cad_operador" align="center" onSubmit="return valida_dados(this)">
						<fieldset><legend align="center">Cadastrar Operador</legend>
							<br/>
							<label> <font color="336699"> Operador: </label> &nbsp;
							<input name="operador" type="text" size="4" maxlength="4" onkeyup='if (isNaN(this.value)) {this.value = ""}'> &nbsp;
							
							<label> <font color="336699"> Nome: </label> &nbsp;
							<input name="nome" type="text" size="30" maxlength="30" > &nbsp;
									
							<input type="submit" name="ok" value="ok"> &nbsp; &nbsp; &nbsp;
							<br/> <br/>
						</fieldset>
					</form>
					</td>
					</tr>
					</table>
					<br/>
					<hr width="90%">
					<br/><br/>
				<?php } ?>
				
				</div>
				<br/><br/>
				<?php 
					include('../../rodape.php');
				?>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>