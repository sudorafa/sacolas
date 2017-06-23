<?php
	session_start();
	/*
	Form . do sistema
	Rafael Eduardo L - Aux. Informática
	Filial 47, Recife, 29 de Setembro de 2016
	*/
	include('../../global/conecta.php');
	include('../../global/libera.php');
	//include("/controller/ip.php");
	//include('../menu.php');
	
	$dataInicial1 = $_POST['dataInicial'];
	$dataInicial  = explode('/', $dataInicial1);
	$dataInicial  = $dataInicial[2].'-'.$dataInicial[1].'-'.$dataInicial[0];
	
	$dataFinal1	  = $_POST['dataFinal'];		
	$dataFinal    = explode('/', $dataFinal1);
	$dataFinal 	  = $dataFinal[2].'-'.$dataFinal[1].'-'.$dataFinal[0];
	
	$avaria 	  = mysql_query("select data, sum(qtd) as qtds from Avaria_Sacola where data between '$dataInicial' and '$dataFinal' group by data order by data");
	
	$linhaAvaria  = mysql_num_rows($avaria);
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body> 
	<!-- --------------------------------------------------------------------------------------- -->
	
	<!-- --------------------------------------------------------------------------------------- -->
		<div id="interface">
			<div id="Conteudo">
				<div align="center">
					<br/><br/>
					<h2 align="center"> <font color="336699"> Sacolas Avariadas Registradas </br> <?php echo $dataInicial1 ?> a <?php echo $dataFinal1 ?> </font></h2> 
					<br/> <br/> 
					<table cellpadding="0" border="1" width="40%" align="center">
						<tr>
							<td class="title" height="26"> DATA </td>
							<td class="title" height="26"> Quantidade </td>
						</tr>
						<?php
							while ($dadosAvaria = mysql_fetch_array($avaria)){
						
							$data1		= $dadosAvaria[data];
							$data  = explode('-', $data1);
							$data  = $data[2].'/'.$data[1].'/'.$data[0];
						?>
						<tr>
							<td class="corpo" height="26" > <?php echo $data?> </td>
							<td class="corpo" height="26" > <?php echo $dadosAvaria[qtds]?> </td>
						<?php };?>
						</tr>

					</table>
				</div>
				<br/><br/>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>