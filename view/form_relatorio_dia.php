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
	<body onLoad="document.form_relatorio_dia.data.focus()"> 
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
	function valida_dados (form_relatorio_dia)
	{
		if (form_relatorio_dia.data.value=="")
		{
			alert ("Por favor digite a data.");
			form_relatorio_dia.data.focus();
			return false;
		}	
		
		if (form_relatorio_dia.diverg.value==0)
		{
			alert ("Por favor escolha diverg para listar.");
			form_relatorio_dia.diverg.focus();
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
					<h2 align="center"> <font color="336699"> ESTATISTICAS DIARIA </font></h2> 
					<br/>
					<table cellpadding="0" border="1" width="80%" align="center">
					<tr>
						<form action="form_relatorio_dia.php" method="post" name="form_relatorio_dia" align="center" onSubmit="return valida_dados(this)">
						<td	class="corpo" align="center" width="60%"> 
							<br/>	
							<label> <font color="336699">  Listar Estatisticas do Dia: </label> &nbsp;
							<br/> <br/>
							
							<label> <font color="336699">  Digite a Data: </label> &nbsp;
							<input type="text" name="data" value="<?php echo $_POST[data]?>" size="10" maxlength="10" onkeyup="Formatadata(this,event)" />&nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;
							
							<label> <font color="336699">  Diverg: </label> &nbsp;
							<select size="1" name="diverg">
								<option value="<?php echo $_POST[diverg]?>"><?php echo $_POST[diverg]?></option>
								<option value="0">--</option>
								<option value="TODOS">TODOS</option>
								<option value="FALTA">FALTA</option>
								<option value="SOBRA">SOBRA</option>
								<option value="ZERO">ZERO</option>
							</select> &nbsp; &nbsp;
									
							<input type="submit" name="listar" value="listar">
							
							<br/> <br/>
							<br/>
						</td>
						</form>
					</tr>
					</table> 
						
						<?php 
							
							$data1 	= $_POST['data'];
							
							$data = explode('/', $data1);
							$data = $data[2].'-'.$data[1].'-'.$data[0];
							 
							$consulta = mysql_query("select * from Mov_Sacolas_Saida where data = '$data'");
							$linha = mysql_num_rows($consulta);
					 
							
							
							if(($_POST[data]) or ($_POST[data] <> "") or ($_POST[data] <> 0)){
								
								if($linha > 0)
								{
									//  existe;
									/*?><h5 align="center"> <a href="form_listar_relatorio_dia.php?data=<?php echo $_POST[data]?>&diverg=<?php echo $_POST[diverg]?>&imp=sim"target="_blank">visualizar impressao</a></h5> <?php*/
									include("form_listar_relatorio_dia.php");
									
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