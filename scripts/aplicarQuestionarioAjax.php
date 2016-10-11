<?php
	//Imports
	require_once "../classes/conexao.class.php";
	
	//Inicia a seção
	session_start();

	//Data e hora atual
    date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');
	
	$conexao = new Conexao();
	
	$cod_questionario = $_POST["cod_questionario"];
	$cod_turma = $_POST["cod_turma"];	

	$data_inicio = $_POST["data_inicio"]." ".$_POST["hora_inicio"];
    $data_inicio = date("Y-m-d H:i:s", strtotime($data_inicio));

    $data_fim = $_POST["data_fim"]." ".$_POST["hora_fim"];
    $data_fim = date("Y-m-d H:i:s", strtotime($data_fim));
	
	if ($data_fim <= $data_inicio){
		echo "A data e hora final não pode ser menor ou igual que a data inicial."; //Retorna Msg de erro para o javascript
	}else if(verificaAplicacao($cod_questionario, $cod_turma)){
		echo "Esse questionário já foi aplicado para essa turma dentro da data especificada."; //Retorna Msg de erro para o javascript
	}else{
		$query = "INSERT INTO questionario_turma VALUES (".$cod_questionario.", ".$cod_turma.", '".$data_inicio."', '".$data_fim."');";

		if($conexao->executaComando($query)){
			echo "true"; //Retorna sucesso para o Javascript
		}else{
			echo "Ocorreu um erro ao aplicar o questionário"; //Retorna Msg de erro para o javascript	
		}
	}

	//Método para verificar se o questionário já está aplicado
	function verificaAplicacao($cod_questionario, $cod_turma){
		
		global $conexao, $data_inicio, $data_fim;

		$resultado = $conexao->executaComando("SELECT data_fim, data_inicio FROM questionario_turma WHERE quest_codigo=".$cod_questionario." AND turma_codigo=".$cod_turma.";");
		
		if(mysqli_num_rows($resultado) != 0){
			while($linha = mysqli_fetch_array($resultado)){

				$data_fim_BD = date("Y-m-d H:i:s", strtotime($linha["data_fim"]));
				$data_inicio_BD = date("Y-m-d H:i:s", strtotime($linha["data_inicio"]));

				//Verifica se o questionário já está aplicado dentro da faixa de tempo específicada
				if(($data_inicio <= $data_fim_BD) && ($data_inicio >= $data_inicio_BD)){
					return true;	
				}else{
					if(($data_fim >= $data_inicio_BD) && ($data_inicio <= $data_fim_BD)){
						return true;
					}else{
						return false;
					}
				}
			}
		}else{
			return false;
		}
	}	
?>