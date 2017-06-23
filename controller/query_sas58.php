<?php

	//form para atualizar as vendas de sacolas atraves do relatorio gerado na tela SAVE SASOI58
	//Informática Atacadão Filial 47 - Recife
    
    include('../../global/conecta.php');
	include('../../global/libera.php');
	
	$servidor = `uname -a | awk -F" " '{print $2}'`;
	$filial1  = trim($servidor);
    
    $arqInicial = explode('.',$_FILES['arq_csv']['name']);
    $tipoArquivo = end($arqInicial);
    
    if(isset($_FILES['arq_csv']['name']) and $tipoArquivo == 'csv' )
    {
        // nome temporário para o arquivo
        $tmpName = $_FILES['arq_csv']['tmp_name']; 
        
        //novo nome que o arquivo será salvo
        $newName = 'recargas'.$dt_banco.$_FILES['arq_csv']['new_name'].'.csv';
        
            if(!move_uploaded_file($tmpName, '../arquivos/'. $newName))
            {
               
               // throw new ErrorLog("Erro ao enviar arquivo" {$tmpName});
            }
            else
            {
                //abrindo o arquivo  
                $abreArq = fopen('../arquivos/'.$newName,'r');
                if (!isset($abreArq)){
                 //   throw new ErrorLog("Não foi possível localizar o Arquivo");
                    
                }
				
				$i=1;
				
                while($valores = fgetcsv($abreArq,2048,';'))
                {
					
                    $data = explode('/', $valores[0]);
					$data = $data[2].'-'.$data[1].'-'.$data[0];
					
					$pdv = $valores[2];
					
					$cupom = $valores[4];
					
					$operador = $valores[3];
					$operador = substr($operador,0,4);
					$operador = preg_replace("/[^0-9]/", "", $operador);
					$operador = trim($operador);
					
					$qtd = $valores[13];
					
					$situacao = $valores[18];
					$situacao = trim($situacao);
					
					$codMercadoria = $valores[6];
					
					//verificar se tem dados com a data para add
					if($i == 2) {
						$sql = "select * from Venda_Sacolas where data = '$data'";
						$qry = mysql_query($sql);
						$tot_linha = mysql_num_rows($qry);
					}
					
					// echo "$data $valores[14] $NovoValor <br>";
				   
				   
					if($tot_linha == 0 and $situacao == "" and $codMercadoria == 26851) {
						$query = "insert into Venda_Sacolas (pdv, cupom, data, operador, qtd, filial, situacao) values ($pdv, $cupom, '$data', $operador, $qtd, '$filial1', '$situacao')";
						if( mysql_query($query)){
							$retorna = "true";
						}
					}else {
						$retorna = "falso";
					}
					
				$i++;
				}
				
				if($retorna == "true") {
					echo 
					"<script>window.alert('Dados Atualzizados com Sucesso !')
						window.location.replace('../view/form_upar.php');
					</script>";	
				} else {
					echo 
					"<script>window.alert('Dados Não Atualzizados [ JÁ EXISTE VENDA NESTA DATA ] !')
						window.location.replace('../view/form_upar.php');
					</script>";	
				}
				
			}
    }
    else
    {
        if(end($arqInicial) != 'csv')
        {
            echo 
				"<script>window.alert('Formato de Arquivo Inválido! Os arquivos devem está no Formato .csv !')
					window.location.replace('../view/form_upar.php');
				</script>";	
		}
    }
    
?>
	