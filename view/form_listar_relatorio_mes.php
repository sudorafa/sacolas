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
	
	$imp	= $_GET[imp];
	
	if($imp=="sim"){
		//include('impressao.php');	
		$ano	= $_GET[ano];
		$mes1	= $_GET[mes];
		
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
		
		$mes = $meses[$mes1];
		
	}else{
		$ano	= $_POST["ano"];
		$mes1	= $_POST["mes"];
		
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
		
		$mes = $meses[$mes1];
		
	}
	
	//avaria
	$avaria 	  	= mysql_query("select sum(qtd) as qtdAvarias from Avaria_Sacola where data between '$ano-$mes-01' and '$ano-$mes-31'");
	$dadosAvaria 	= mysql_fetch_array($avaria);
	$avaria		= $dadosAvaria[qtdAvarias];
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body> 
		<br/><br/>
		<div id="interface">
			<div id="Conteudo">
				<div align="center">
					<br/>
					<h2 align="center"> <font color="336699"> Estatisticas Mes de <?php echo $mes1 ?> </font></h2> 
					<br/>
					<table cellpadding="0" border="1" width="70%" align="center">
					<tr>
						<td class="title" height="26"> DIA </td>
						<td class="title" height="26"> QTD SAIDA </td>
						<td class="title" height="26"> QTD DEVOL </td>
						<td class="title" height="26"> QTD VENDIDO </td>
						<td class="title" height="26"> QTD PERDA </td>
					<?php if($imp<>"sim"){?>
						<td class="title" height="26"> DETALHE </td>
					<?php } ?>
					</tr>
					<?php
					
					//totais
					for($i=01;$i<=31;$i++) {
						
						//dados MOV SAIDA
						$movSaida 	  	= mysql_query("select sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where data = '$ano-$mes-$i'");
						$dadosMovSaida 	= mysql_fetch_array($movSaida);
						$qtdSaida		= $dadosMovSaida[qtdSaidas];

						$dadosLinhaSaida 	 = mysql_query("select operador from Mov_Sacolas_Saida where data = '$ano-$mes-$i' group by operador");
						$linhaSaida			 = mysql_num_rows($dadosLinhaSaida);
						
						//dados MOV DEVOLUCAO
						$movDevolucao  		= mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where data = '$ano-$mes-$i'");
						$dadosMovDevolucao 	= mysql_fetch_array($movDevolucao);
						$qtdDevolucao		= $dadosMovDevolucao[qtdDevolucoes];
						
						if ($qtdDevolucao == 0){
							$qtdDevolucao		= "0";
						}
						
						$dadosLinhaDevolucao = mysql_query("select operador from Mov_Sacolas_Devolucao where data = '$ano-$mes-$i' group by operador");
						$linhaDevolucao		 = mysql_num_rows($dadosLinhaDevolucao);
						
						//Venda
						$vendas 		= mysql_query("select sum(qtd) as qtdTotal from Venda_Sacola where data = '$ano-$mes-$i'");
						$dadosVendas 	= mysql_fetch_array($vendas);
						$qtdVenda 		= $dadosVendas[qtdTotal];
						
						$dadosLinhaVenda= mysql_query("select operador from Venda_Sacola where data = '$ano-$mes-$i' group by operador");
						$linhaVenda		= mysql_num_rows($dadosLinhaVenda);
					
						//diverg
						$diverg = ($qtdSaida - $qtdDevolucao) - $qtdVenda;
						
						$perda = - $qtdFalta - $qtdSobra;
						
						$totalSaidas 	= $totalSaidas + $qtdSaida;
						$totalDevolucoes= $totalDevolucoes + $qtdDevolucao;
						$totalvendido	= $totalvendido + $qtdVenda;
						
						//tem venda mais nao tem saida
						if($linhaVenda > 0 and $linhaSaida == 0){
							?>	
							<tr>
								<td class="corpo" height="26" > <?php echo $i ?> </td>
								<td class="corpo" height="26" > 0 </a> </td>
								<td class="corpo" height="26" > 0 </td>
								<td class="corpo" height="26" > <?php echo $qtdVenda ?> </td>
								<td class="corpo" height="26" > <?php echo $diverg ?> </td>
							<?php if($imp<>"sim"){?>
								<td class="corpo" height="26" > <a href="form_listar_relatorio_dia.php?data=<?php echo $i.'/'.$mes.'/'.$ano?>&diverg=TODOS&imp=sim">...</a> </td>
							<?php } ?>
							</tr>
						<?php 
						//não tem venda mais tem saida
						} else if($linhaVenda == 0 and $linhaSaida > 0){
							?>	
							<tr>
								<tr>
								<td class="corpo" height="26" > <?php echo $i?> </td>
								<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
								<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
								<td class="corpo" height="26" > Waiting... </td>
								<td class="corpo" height="26" > Waiting... </td>
							<?php if($imp<>"sim"){?>
								<td class="corpo" height="26" > <a href="form_listar_relatorio_dia.php?data=<?php echo $i.'/'.$mes.'/'.$ano?>&diverg=TODOS&imp=sim">...</a> </td>
							<?php } ?>
							</tr>
						<?php 
						//tem venda e saida
						} else if ($linhaVenda > 0 and $linhaSaida > 0){
							$perdaTotal			= $perdaTotal + $diverg;
							?>	
							<tr>
								<tr>
								<td class="corpo" height="26" > <?php echo $i?> </td>
								<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
								<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
								<td class="corpo" height="26" > <?php echo $qtdVenda?> </td>
								<td class="corpo" height="26" > <?php echo $diverg?> </td>
							<?php if($imp<>"sim"){?>
								<td class="corpo" height="26" > <a href="form_listar_relatorio_dia.php?data=<?php echo $i.'/'.$mes.'/'.$ano?>&diverg=TODOS&imp=sim">...</a> </td>
							<?php } ?>
							</tr>
						<?php 
						}
					}
					?>
					</table>
					
					<h3 align="center"> <font color="blue"> Qtd Saida: <?php echo $totalSaidas ?> | Qtd. Devolucao: <?php echo $totalDevolucoes ?> | Qtd. Vendido: <?php echo $totalvendido ?> </br>
															Qtd. Avaria: <?php echo $avaria ?> | Qtd. Perda: <?php echo $perdaTotal - $avaria ?> (Perda - Avaria)</font></h2> 
				</div>
				<br/><br/>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>