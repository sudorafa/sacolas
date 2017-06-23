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
		include('../cabecalho.php');
		//include('impressao.php');	
		$data1	= $_GET[data];
		$diverg	= $_GET[diverg];
	}else{
		$data1 		= $_POST['data'];
		$diverg 	= $_POST['diverg'];
	}
	$data = explode('/', $data1);
	$data = $data[2].'-'.$data[1].'-'.$data[0];
	
	//operadores
	$operadores 	  	= mysql_query("select numOperador, nomeOperador from operadoresrec group by numOperador");
	$operadores1 	  	= mysql_query("select numOperador, nomeOperador from operadoresrec group by numOperador");
	$operadores2 	  	= mysql_query("select numOperador, nomeOperador from operadoresrec group by numOperador");
	
	//dados Venda
	$vendas 	  		= mysql_query("select sum(qtd) as qtds from Venda_Sacola where data = '$data'");
	$dadosVendas		= mysql_fetch_array($vendas);
	
	//qyd total
	$qtdVenda = $dadosVendas[qtds];
	
	$linhaVendas = mysql_query("select operador from Venda_Sacola where data = '$data'");
	$qtdVendas	 = mysql_num_rows($linhaVendas);
	
	$contar 	= 0;
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>		
	</head>
	<body> 
		<div id="interface">
			<?php
				if($imp=="sim"){
					include('../menu.php');
				}else{
					?> <br/><br/> <?php
				}
			?>
			<div id="Conteudo">
				<div align="center">
					<br/>
					<?php if ($diverg == "TODOS"){ ?>
						<h2 align="center"> <font color="336699"> Estatisticas dia <?php echo $data1 ?></font></h2> 
					<?php }else if ($diverg == "ZERO"){ ?>
						<h2 align="center"> <font color="336699"> Estatisticas dia <?php echo $data1 ?> com Diverg Zero de Sacolas</font></h2> 
					<?php }else{ ?>
						<h2 align="center"> <font color="336699"> Estatisticas dia <?php echo $data1 ?> com <?php echo $diverg ?> de Sacolas</font></h2> 
					<?php } ?>
						
					<br/> <br/> 
					
					<?php
					//comeca aqui o todos
					if($qtdVendas > 0){
						if($diverg == "TODOS"){
							
							//começa aqui o zero
							?>
							<table cellpadding="0" border="1" width="70%" align="center">
							<tr>
								<td class="title" height="26"> OPER </td>
								<td class="title" height="26"> NOME </td>
								<td class="title" height="26"> SAIDA </td>
								<td class="title" height="26"> DEVOL </td>
								<td class="title" height="26"> VENDIDO </td>
								<td class="title" height="26"> DIVERG </td>
							</tr>
							
							<?php
							
							while ($dados = mysql_fetch_array($operadores)){
						?>
							<?php 
								//nome Operador:
								$oper 	= $dados[numOperador];
								$nome 	= $dados[nomeOperador];
								
								
								//Vendas Operador
								$vendaOperador 		= mysql_query("select sum(qtd) as qtds from Venda_Sacola where operador = $oper and data = '$data'");
								$dadosOperadorVenda	= mysql_fetch_array($vendaOperador);

								$dadosLinhaVenda 	 = mysql_query("select operador from Venda_Sacola where operador = $oper and data = '$data'");
								$linhaVenda			 = mysql_num_rows($dadosLinhaVenda);
								
								if($linhaVenda == 0){
									$operadorVendas = 0;
								}else {
									$operadorVendas		= $dadosOperadorVenda[qtds];
								}
								
								//dados MOV SAIDA
								$movSaida 	  	= mysql_query("select sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
								$dadosMovSaida 	= mysql_fetch_array($movSaida);
								
								$dadosLinhaSaida 	 = mysql_query("select operador from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
								$linhaSaida			 = mysql_num_rows($dadosLinhaSaida);
								
								if($linhaSaida == 0){
									$qtdSaida = 0;
								}else {
									$qtdSaida		= $dadosMovSaida[qtdSaidas];
								}
								
								//dados MOV DEVOLUCAO
								$movDevolucao  		= mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
								$dadosMovDevolucao 	= mysql_fetch_array($movDevolucao);
								
								
								$dadosLinhaDevolucao = mysql_query("select operador from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
								$linhaDevolucao		 = mysql_num_rows($dadosLinhaDevolucao);
								
								if($linhaDevolucao == 0){
									$qtdDevolucao = 0;
								}else {
									$qtdDevolucao		= $dadosMovDevolucao[qtdDevolucoes];
								}
								
								//dados Sobra:
								$sobra = $operadorVendas - ($qtdSaida - $qtdDevolucao);
								
								if ($linhaVenda > 0 || $linhaSaida > 0){
									
									if ($sobra == 0){
										?>	
										<tr>
											<td class="corpo" height="26" > <?php echo $oper?> </td>
											<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
											<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
											<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
											<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
											<td class="corpo" height="26" > <?php echo $sobra?> </td>
										</tr>
										<?php 	
										$contar = $contar + 1;
										$qtdVendido = $qtdVendido + $qtdVenda;
									}
								}
							}
							
							///acaba aqui o zero
							
							//começa aqui o falta
							
							while ($dados = mysql_fetch_array($operadores1)){
						?>
							<?php 
								//nome Operador:
								$oper 	= $dados[numOperador];
								$nome 	= $dados[nomeOperador];
								
								
								//Vendas Operador
								$vendaOperador 		= mysql_query("select sum(qtd) as qtds from Venda_Sacola where operador = $oper and data = '$data'");
								$dadosOperadorVenda	= mysql_fetch_array($vendaOperador);

								$dadosLinhaVenda 	 = mysql_query("select operador from Venda_Sacola where operador = $oper and data = '$data'");
								$linhaVenda			 = mysql_num_rows($dadosLinhaVenda);
								
								if($linhaVenda == 0){
									$operadorVendas = 0;
								}else {
									$operadorVendas		= $dadosOperadorVenda[qtds];
								}
								
								//dados MOV SAIDA
								$movSaida 	  	= mysql_query("select sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
								$dadosMovSaida 	= mysql_fetch_array($movSaida);
								
								$dadosLinhaSaida 	 = mysql_query("select operador from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
								$linhaSaida			 = mysql_num_rows($dadosLinhaSaida);
								
								if($linhaSaida == 0){
									$qtdSaida = 0;
								}else {
									$qtdSaida		= $dadosMovSaida[qtdSaidas];
								}
								
								//dados MOV DEVOLUCAO
								$movDevolucao  		= mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
								$dadosMovDevolucao 	= mysql_fetch_array($movDevolucao);
								
								
								$dadosLinhaDevolucao = mysql_query("select operador from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
								$linhaDevolucao		 = mysql_num_rows($dadosLinhaDevolucao);
								
								if($linhaDevolucao == 0){
									$qtdDevolucao = 0;
								}else {
									$qtdDevolucao		= $dadosMovDevolucao[qtdDevolucoes];
								}
								
								//dados Sobra:
								$sobra = $operadorVendas - ($qtdSaida - $qtdDevolucao);
									
								if ($sobra < 0){
									?>	
									<tr>
										<td class="corpo" height="26" > <?php echo $oper?> </td>
										<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
										<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
										<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
										<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
										<td class="corpo" height="26" > <?php echo $sobra?> </td>
									</tr>
									<?php 	
									$contar = $contar + 1;
									$qtdVendido = $qtdVendido + $qtdVenda;
									$qtdFalta = $qtdFalta + $sobra;
									
								}
							
							}
							///acaba aqui o falta
							
							//começa aqui o sobra
							
							while ($dados = mysql_fetch_array($operadores2)){
						?>
							<?php 
								//nome Operador:
								$oper 	= $dados[numOperador];
								$nome 	= $dados[nomeOperador];
								
								
								//Vendas Operador
								$vendaOperador 		= mysql_query("select sum(qtd) as qtds from Venda_Sacola where operador = $oper and data = '$data'");
								$dadosOperadorVenda	= mysql_fetch_array($vendaOperador);

								$dadosLinhaVenda 	 = mysql_query("select operador from Venda_Sacola where operador = $oper and data = '$data'");
								$linhaVenda			 = mysql_num_rows($dadosLinhaVenda);
								
								if($linhaVenda == 0){
									$operadorVendas = 0;
								}else {
									$operadorVendas		= $dadosOperadorVenda[qtds];
								}
								
								//dados MOV SAIDA
								$movSaida 	  	= mysql_query("select sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
								$dadosMovSaida 	= mysql_fetch_array($movSaida);
								
								$dadosLinhaSaida 	 = mysql_query("select operador from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
								$linhaSaida			 = mysql_num_rows($dadosLinhaSaida);
								
								if($linhaSaida == 0){
									$qtdSaida = 0;
								}else {
									$qtdSaida		= $dadosMovSaida[qtdSaidas];
								}
								
								//dados MOV DEVOLUCAO
								$movDevolucao  		= mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
								$dadosMovDevolucao 	= mysql_fetch_array($movDevolucao);
								
								
								$dadosLinhaDevolucao = mysql_query("select operador from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
								$linhaDevolucao		 = mysql_num_rows($dadosLinhaDevolucao);
								
								if($linhaDevolucao == 0){
									$qtdDevolucao = 0;
								}else {
									$qtdDevolucao		= $dadosMovDevolucao[qtdDevolucoes];
								}
								
								//dados Sobra:
								$sobra = $operadorVendas - ($qtdSaida - $qtdDevolucao);
								
								if ($linhaVenda > 0 || $linhaSaida > 0){
									
									if ($sobra > 0){
										?>	
										<tr>
											<td class="corpo" height="26" > <?php echo $oper?> </td>
											<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
											<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
											<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
											<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
											<td class="corpo" height="26" > <?php echo $sobra?> </td>
										</tr>
										<?php 	
										$contar = $contar + 1;
										$qtdVendido = $qtdVendido + $qtdVenda;
										$qtdSobra = $qtdSobra + $sobra;
									}
								}
							}
							$perda = - $qtdFalta - $qtdSobra;
							?>
							</table>
							<?php
							///acaba aqui o Sobra
						}
						//termina aqui o todos
						if($diverg != "TODOS"){
						?>
							<table cellpadding="0" border="1" width="70%" align="center">
							<tr>
								<td class="title" height="26"> OPER </td>
								<td class="title" height="26"> NOME </td>
								<td class="title" height="26"> SAIDA </td>
								<td class="title" height="26"> DEVOL </td>
								<td class="title" height="26"> VENDIDO </td>
								<td class="title" height="26"> DIVERG </td>
							</tr>
						<?php
						}
						while ($dados = mysql_fetch_array($operadores)){
					?>
						<?php 
							//nome Operador:
							$oper 	= $dados[numOperador];
							$nome 	= $dados[nomeOperador];
							
							
							//Vendas Operador
							$vendaOperador 		= mysql_query("select sum(qtd) as qtds from Venda_Sacola where operador = $oper and data = '$data'");
							$dadosOperadorVenda	= mysql_fetch_array($vendaOperador);

							$dadosLinhaVenda 	 = mysql_query("select operador from Venda_Sacola where operador = $oper and data = '$data'");
							$linhaVenda			 = mysql_num_rows($dadosLinhaVenda);
							
							if($linhaVenda == 0){
								$operadorVendas = 0;
							}else {
								$operadorVendas		= $dadosOperadorVenda[qtds];
							}
							
							//dados MOV SAIDA
							$movSaida 	  	= mysql_query("select sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
							$dadosMovSaida 	= mysql_fetch_array($movSaida);
							
							$dadosLinhaSaida 	 = mysql_query("select operador from Mov_Sacolas_Saida where operador = $oper and data = '$data'");
							$linhaSaida			 = mysql_num_rows($dadosLinhaSaida);
							
							if($linhaSaida == 0){
								$qtdSaida = 0;
							}else {
								$qtdSaida		= $dadosMovSaida[qtdSaidas];
							}
							
							//dados MOV DEVOLUCAO
							$movDevolucao  		= mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
							$dadosMovDevolucao 	= mysql_fetch_array($movDevolucao);
							
							
							$dadosLinhaDevolucao = mysql_query("select operador from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
							$linhaDevolucao		 = mysql_num_rows($dadosLinhaDevolucao);
							
							if($linhaDevolucao == 0){
								$qtdDevolucao = 0;
							}else {
								$qtdDevolucao		= $dadosMovDevolucao[qtdDevolucoes];
							}
							
							//dados Sobra:
							$sobra = $operadorVendas - ($qtdSaida - $qtdDevolucao);
							
							if ($linhaVenda > 0 || $linhaSaida > 0){
								
								if($diverg == "FALTA"){
									if ($sobra < 0){
										?>	
										<tr>
											<td class="corpo" height="26" > <?php echo $oper?> </td>
											<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
											<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
											<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
											<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
											<td class="corpo" height="26" > <?php echo $sobra?> </td>
										</tr>
										<?php 
										$contar = $contar + 1;
										$qtdFalta = $qtdFalta + $sobra;
										$qtdVendido = $qtdVendido + $qtdVenda;
									}
								}else if ($diverg == "SOBRA"){
									if ($sobra > 0){
										?>	
										<tr>
											<td class="corpo" height="26" > <?php echo $oper?> </td>
											<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
											<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
											<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
											<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
											<td class="corpo" height="26" > <?php echo $sobra?> </td>
										</tr>
										<?php 
										$contar = $contar + 1;
										$qtdSobra = $qtdSobra + $sobra;
										$qtdVendido = $qtdVendido + $qtdVenda;
									}
								}else if ($diverg == "ZERO"){
									if ($sobra == 0){
										?>	
										<tr>
											<td class="corpo" height="26" > <?php echo $oper?> </td>
											<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
											<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
											<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
											<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
											<td class="corpo" height="26" > <?php echo $sobra?> </td>
										</tr>
										<?php 	
										$contar = $contar + 1;
										$qtdVendido = $qtdVendido + $qtdVenda;
									}
								}else{
									?>	
									<tr>
										<td class="corpo" height="26" > <?php echo $oper?> </td>
										<td class="corpo" height="26" > <?php echo strtoupper($nome)?></a> </td>
										<td class="corpo" height="26" > <?php echo $qtdSaida?> </td>
										<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
										<td class="corpo" height="26" > <?php echo $operadorVendas?> </td>
										<td class="corpo" height="26" > <?php echo $sobra?> </td>
									</tr>
									<?php 
									$contar 	= $contar + 1;
									//sobra
									if ($sobra > 0) {
										$qtdSobra = $qtdSobra + $sobra;
									} 
									//falta
									else if ($sobra < 0){
										$qtdFalta = $qtdFalta + $sobra;
									}
									$qtdVendido = $qtdVendido + $qtdVenda;
									
								}
							}
						}
						
					}
					
					else{
						?>
						<table cellpadding="0" border="1" width="70%" align="center">
						<tr>
							<td class="title" height="26"> OPER </td>
							<td class="title" height="26"> NOME </td>
							<td class="title" height="26"> SAIDA </td>
							<td class="title" height="26"> DEVOL </td>
							<td class="title" height="26"> VENDIDO </td>
							<td class="title" height="26"> DIVERG </td>
						</tr>
						<?php
						$mov = mysql_query("select operador, sum(qtdSaida) as qtdSaidas from Mov_Sacolas_Saida where data = '$data' group by operador order by operador");
						while ($dadosMov = mysql_fetch_array($mov)){
							//nome Operador:
							$oper 	= $dadosMov[operador];
							$nome 	= mysql_query("select nomeOperador from operadoresrec where numOperador = $oper");
							$dadosNome = mysql_fetch_array($nome);
							

							//dados MOV DEVOLUCAO
							$movDevolucao  		 = mysql_query("select sum(qtdDevolucao) as qtdDevolucoes from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
							$dadosMovDevolucao 	= mysql_fetch_array($movDevolucao);
							
							$dadosLinhaDevolucao = mysql_query("select operador from Mov_Sacolas_Devolucao where operador = $oper and data = '$data'");
							$linhaDevolucao		 = mysql_num_rows($dadosLinhaDevolucao);
							
							if($linhaDevolucao == 0){
								$qtdDevolucao = 0;
							}else {
								$qtdDevolucao		= $dadosMovDevolucao[qtdDevolucoes];
							}
						?>
						<tr>
							<td class="corpo" height="26" > <?php echo $oper?> </td>
							<td class="corpo" height="26" > <?php echo strtoupper($dadosNome[nomeOperador])?></a> </td>
							<td class="corpo" height="26" > <?php echo $dadosMov[qtdSaidas]?> </td>
							<td class="corpo" height="26" > <?php echo $qtdDevolucao?> </td>
							<td class="corpo" height="26" > Waiting... </td>
							<td class="corpo" height="26" > Waiting... </td>
						</tr>
						<?php
						$contar = $contar + 1;
						}
						$perda = "";
						$qtdSobra = "";
						$qtdFalta = "";
						$qtdVendido = "";
					};?>

				</table>

					<?php if ($diverg == "FALTA"){ ?>
						<h3 align="center"> <font color="blue"> Operadores: <?php echo $contar ?> | Qtd. Falta: <?php echo $qtdFalta ?> </font></h2> 
					<?php }else if ($diverg == "SOBRA"){ ?>
						<h3 align="center"> <font color="blue"> Operadores: <?php echo $contar ?> | Qtd. Sobra: <?php echo $qtdSobra ?> </font></h2> 
					<?php }else if ($diverg == "ZERO"){ ?>
						<h3 align="center"> <font color="blue"> Operadores: <?php echo $contar ?> </font></h2> 
					<?php }else{ ?>
						<h3 align="center"> <font color="blue"> Operadores: <?php echo $contar ?> | Qtd. Sobra: <?php echo $qtdSobra ?> | Qtd. Falta: <?php echo $qtdFalta ?> | Vendido: <?php echo $qtdVenda ?> | Perda: <?php echo $perda ?></font></h2> 
					<?php } ?>
				</div>
				<br/><br/>
			</div> <!--/conteudo -->
        </div> <!--/interface -->
		
    </body>
</html>