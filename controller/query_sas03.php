<?php

	//form para atualizar as vendas de sacolas atraves do relatorio gerado na tela SAVE SASOI03
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
        $newName = 'sasoi03'.$dt_banco.$_FILES['arq_csv']['new_name'].'.csv';
        
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
					if ($i == 1){
						$data = $valores[3];
						$data = substr($data,0,10);
						$data = explode('/', $data);
						$data = $data[2].'-'.$data[1].'-'.$data[0];
						
						$data1 = $valores[3];
						$data1 = substr($data1,15,25);
						$data1 = explode('/', $data1);
						$data1 = $data1[2].'-'.$data1[1].'-'.$data1[0];
						
						
						$codMercadoria = $valores[4];
						
						//verificar se tem dados com a data para add
						$sql = "select * from Venda_Sacola where data = '$data'";
						$qry = mysql_query($sql);
						$tot_linha = mysql_num_rows($qry);
						
						if($tot_linha > 0){
							$retorna = "falso";
							$throw	 = "Ja Existe Atualizacao Para Esta Data !";
						} else if ($codMercadoria <> "26851"){
							$retorna = "falso";
							$throw	 = "Codigo da Sacola Invalido !";
						} else if($data <> $data1){
							$retorna = "falso";
							$throw	 = "SASOI03 Deve Ter Apenas Um Dia !";
						} else{
							$retorna = "true";
						}
					}
                    
										
					$operador = $valores[0];
					
					$qtd = $valores[2];
					
					
					if($retorna == "true") {
						$query = "insert into Venda_Sacola (operador, qtd, data, filial) values ($operador, $qtd, '$data', '$filial1')";
						if( mysql_query($query)){}
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
					"<script>window.alert('Nao Atualizado, Erro: $throw - Consultar Arquivo SASOI03 ! ')
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
	