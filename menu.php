<?php
/*
	Form Criado para carregar o menu do Portal
	Rafael Eduardo L - Aux. Inform�tica
	Recife, 29 de Setembro de 2016
*/
	session_start();
?>

<html>
    <head>
		<meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>
		<script>
			//window.location.href='#foo';
		</script>
	</head>
    <body>
		<!--<a href="#" id="foo"></a>-->
		<!-- -------------------------------------------------------------------- -->
		<!-- ------------------------- Barra de Menu ---------------------------- -->
		<!-- -------------------------------------------------------------------- -->
			<section id="menu">
                <ul>
					<li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
						<li><a> | </a></li>
                    <li><a href="#" title="Descri��o" target="_blank">MENU SYS</a></li>
				</ul>
			</section>
			<section id="menuLogado3">
				<ul>
					<li><a href="/sacolas/view/form_saidas.php" title="Inicio/Sa�das - Controle de Sacolas">SA�DAS</a></li>
						<li><a> | </a></li>
					<li><a href="/sacolas/view/form_devolucao.php" title="Devolu��o - Controle de Sacolas">DEVOLU��O</a></li>
						<li><a> | </a></li>
					<li><a href="/sacolas/view/form_avaria.php" title="Avarias - Controle de Sacolas">AVARIA</a></li>
						<li><a> | </a></li>
					<li><a href="/sacolas/view/form_relatorio_dia.php" title="Relat�rios Di�rios - Controle de Sacolas">RELAT DI�RIO</a></li>
						<li><a> | </a></li>
					<li><a href="/sacolas/view/form_relatorio_mes.php" title="Relat�rios Mensais - Controle de Sacolas">RELAT MENSAL</a></li>
						<li><a> | </a></li>
					<li><a href="/sacolas/view/form_verificar_atualizacao_ano.php" title="Atualiza��es - Controle de Sacolas">ATUALIZA��O</a></li>
						<li><a> | </a></li>
					<li><a href="/sacolas/view/form_upar.php" title="Gerenciamento - Controle de Sacolas">ADM</a></li>
				</ul>
			</section>
		<!-- ---------------------------------------------------------------------- -->
		<!-- ----------------------- Barra de Menu Fim ---------------------------- -->
		<!-- ---------------------------------------------------------------------- -->
    </body>
</html>