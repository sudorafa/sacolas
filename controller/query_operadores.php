<?php

	//form para atualizar os operadores.
	//Informática Atacadão Filial 47 - Recife

// este script atualiza a tabela operadores
// esta lista é retirada do tplinux e salva em um arquivo do bloco de notas com o nome operadores.txt
// realizar este procedimento sempre que existir alterações de operadores
include('../../global/conecta.php');
include('../../global/libera.php');
	
	$servidor = `uname -a | awk -F" " '{print $2}'`;
	$filial1  = trim($servidor);

	$arqInicial = explode('.',$_FILES['arq_txt']['name']);
    $tipoArquivo = end($arqInicial);
    
    if(isset($_FILES['arq_txt']['name']) and $tipoArquivo == 'txt' )
    {
        // nome temporário para o arquivo
        $tmpName = $_FILES['arq_txt']['tmp_name']; 
        
        //novo nome que o arquivo será salvo
        $newName = 'operadores'.$dt_banco.$_FILES['arq_txt']['new_name'].'.txt';
        
		if(!move_uploaded_file($tmpName, '../arquivos/'. $newName))
		{
		   
		   // throw new ErrorLog("Erro ao enviar arquivo" {$tmpName});
		}
		else
		{
			//abrindo o arquivo  
			
			$operador = file('../arquivos/operadores.txt'); 
	
			$linha = count($operador);
			$idoperador = 778;
			for( $x=0 ; $x < $linha ; $x++ )
			{
				$numero = substr($operador[$x],0,6);
				$nome = substr($operador[$x],2,24);
				$nome = str_replace("0","",$nome);
				$nome = str_replace("1","",$nome);
				$nome = str_replace("2","",$nome);
				$nome = str_replace("3","",$nome);
				$nome = str_replace("4","",$nome);
				$nome = str_replace("5","",$nome);
				$nome = str_replace("6","",$nome);
				$nome = str_replace("7","",$nome);
				$nome = str_replace("8","",$nome);
				$nome = str_replace("9","",$nome);
				$nome = trim($nome);
				$numero = trim($numero);
				$idoperador ++;
				
				$buscaOperador = "select * from operadoresrec where numOperador = '$numero'";
				$qry = mysql_query($buscaOperador);
				$tot_linha = mysql_num_rows($qry);
				
				if($tot_linha == 0) {
					$sql1 = mysql_query(" insert into operadoresrec(id, numOperador, nomeOperador, filial) values ('$numero', '$numero', '$nome', '$filial1') ");
					//$sql = "update operador set nomoperador = '$nome' where noperador = '$numero' and filial = 47";
					//mysql_query("update operador set nomoperador = '$nome' where noperador = '$numero' and filial = 47");
				}
			}
			echo 
			"<script>window.alert('Operadores foram importados para o banco com sucesso !')
				window.location.replace('../view/form_upar.php');
			</script>";	
		}
	}
    
    else
    {
        if(end($arqInicial) != 'txt')
        {
             echo 
				"<script>window.alert('Formato de Arquivo Inválido! Os arquivos devem está no Formato .txt !')
					window.location.replace('../view/form_upar.php');
				</script>";	
        }
    }
	
	
	
	
	

		
?>