<?php
	/*
		Form Criado para carregar o cabeçalho do Portal
		Rafael Eduardo L - @sudorafa
		Recife, 29 de Setembro de 2016
	*/
	session_start();
	/*
		Voltando 2x o ../ pois o home tá dando "header Location" no form_... em /view
	*/
	include('../../global/conecta.php');
	$perfilAtivo			= $_SESSION["perfil"];
	$idusuario 				= $_SESSION["idusuario"];
	$dados_usuario_logado 	= mysql_fetch_array(mysql_query("select * from usuariosc where idusuario = '$idusuario'"));
	
	$att = mysql_query("select * from Venda_Sacola where data <> '0000-00-00' order by id desc limit 1");
	$dadosAtt = mysql_fetch_array($att);
	$linhas = mysql_num_rows($att);
	
	$dataAtt = $dadosAtt[data];
	$dataAtt = explode("-", $dataAtt);
	$dataAtt = $dataAtt[2] . "/" . $dataAtt[1] . "/" . $dataAtt[0];
	
	if (($_SESSION[perfil] != "CPD") && ($_SESSION[perfil] != "GERENTE") && ($_SESSION[perfil] != "CADASTRO") && ($_SESSION[perfil] != "F. CAIXA")){
		header("Location:/");
	}
	
?>

<html>
    <head>
		<link rel="icon" href="/sacolas/arquivos/favicon10.png" type="image/x-icon" />
        <title> Controle de Sacolas - Nome Empresa </title>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0"/>
        <link type="text/css" rel="stylesheet" href="/_css/style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=11"/>
    </head>
    <body> 
		<div id="interface">
            <header id="cabecalho">
                <a id="logoHeaderEmpresa" href="/index.php">
                    <image title="Intranet Sys - Nome Empresa" alt="Logo Empresa." src="/_imagens/logo.png"/>
                </a>
                <section id="textoCabecalho">
                    <h1 align="right">
                        CONTROLE DE SACOLAS
                    </h1>
					<h2 align="right">
                        <script language="JavaScript">
                            days = new Array("Domingo","Segunda-feira","Terça-feira","Quarta-feira","Quinta-feira",
                                                "Sexta-feira","Sábado");
                            months = new Array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho",
                                                "Agosto","Setembro","Outubro","Novembro","Dezembro");
                            today = new Date();
                            day = days[today.getDay()];
                            month = months[today.getMonth()];
                            date = today.getDate();
                            year = today.getYear() + 1900;
                            document.write (day + ", " + date + " de " + month + " de " + year);
                        </script>
                    </h2>
					<div align="right">
						<?php 
						if ($linhas == 0) { ?>
							<font color="blue" size="-0"> <b> Sistema Sem Dados <br/>
						<?php } else { ?>
							<font color="blue" size="-0"> <b> Sistema Atualizado em <?php echo $dataAtt?> <br/>
						<?php } ?>
					</div>
					<br/>
					<?php
						if($idusuario != "false" && $idusuario != ""){
					?>
						<h2 align="right">Bem Vindo(a) <span><?php echo Strtoupper($dados_usuario_logado[nomusuario]) ?></span></h2>
						<h2 align="right"><!--<a href="/view/form_alterar_senha.php">Mudar Senha</a> | --> <a href="/global/logout.php"> SAIR </a> </h2>
					<?php 
						}else{
					?>
						<h2 align="right">Bem Vindo(a)</h2>
					<?php
						}
					?>
                </section> <!-- /textoCabecalho -->
                <div id="clear"></div> <!-- /clear -->
            </header>
            
        </div> <!--/interface -->

    </body>
</html>