<?php
	//Imports
	require_once "../classes/conexao.class.php";
	
	//Inicia a seção
	session_start();

	$conexao = new Conexao();
	$questionarios = array();

	//Data e hora atual
	date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');


	//Seleciona todos os questionários criados.
	$query = "SELECT * FROM questionario_turma WHERE turma_codigo = ".$_SESSION["user_instituicao"]." AND data_fim > '".$dataAtual."';";
	$todosQuestionarios = $conexao->executaComando($query);

	if(mysqli_num_rows($todosQuestionarios) != 0){
		
		//Seleciona todos os questionários aplicados
		$query2 = "SELECT * FROM questionarios INNER JOIN questionario_turma ON questionarios.quest_codigo=questionario_turma.quest_codigo INNER JOIN materias ON questionarios.quest_materia=materias.materia_codigo WHERE quest_professor='".$_SESSION["user_email"]."' AND questionario_turma.data_fim > '".$dataAtual."';";		
		$questionariosAplicados = $conexao->executaComando($query2);

		//Separa os questionarios que não estão aplicados.
		while($quest = mysqli_fetch_array($todosQuestionarios)){
			$teste = "false";
			
			while($aplicado = mysqli_fetch_array($questionariosAplicados)){
			
				if ($quest["quest_codigo"] == $aplicado["quest_codigo"]){
					$teste = "true";
					
				}else{
					$teste = "false";
				}
			}

			if($teste == "false"){
				array_push($questionarios, 
					array(
						"quest_codigo" => $quest["quest_codigo"],
						"quest_nome" => $quest["quest_nome"],
						"quest_materia" => $quest["materia_nome"],
						"quest_numPerguntas" => $quest["quest_numPerguntas"],
						"quest_tempo" => $quest["quest_tempo"],
						"quest_visualizar_resposta" => $quest["quest_visualizar_resposta"],
						"quest_randomiza_perguntas" => $quest["quest_randomiza_perguntas"],
						"quest_necessita_correcao" => $quest["quest_necessita_correcao"],
					)
				);
			}
		}


		echo json_encode($questionarios);
	}else{
		echo json_encode(0);
	}	
?>