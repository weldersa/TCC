<?php
	//Imports
	require_once "../classes/conexao.class.php";
	
	//Inicia a seção
	session_start();

	//Data e hora atual
    date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');

	$conexao = new Conexao();
	$questionarios = array();
	$contador = 0; //Serve para contar execução do while

	//Seleciona as turmas das quais o usuário faz parte
	$query = "SELECT turma_codigo FROM aluno_turma WHERE aluno_email='".$_SESSION['user_email']."';";
	$turmas = $conexao->executaComando($query);

	//Vetor com todos os códigos de questionarios aplicados para o aluno
	$todosQuestionarios = array();
	$questionariosDisponiveis = array();

	//Seleciona todos os questionários aplicados para essas turmas.
	while($linha = mysqli_fetch_array($turmas)){
		$query = "SELECT * FROM questionario_turma INNER JOIN questionarios ON questionario_turma.quest_codigo=questionarios.quest_codigo INNER JOIN materias ON questionarios.quest_materia=materias.materia_codigo INNER JOIN professores ON questionarios.quest_professor=professores.professor_email INNER JOIN usuarios ON usuarios.user_email=professores.professor_email WHERE turma_codigo=".$linha["turma_codigo"]." AND data_inicio <= '".$dataAtual."' AND data_fim > '".$dataAtual."';";

		$aplicados = $conexao->executaComando($query);

		while($linha2 = mysqli_fetch_array($aplicados)){
			$data_fim_completa = date_create($linha2["data_fim"]);
			$hora_fim = date_format($data_fim_completa, "H:i");
			$data_fim = date_format($data_fim_completa, "d/m/Y");
			$data_fim_completa = date_format($data_fim_completa, "Y-m-d H:i:s");

			$data_inicio_completa = date_create($linha2["data_inicio"]);
			$hora_inicio = date_format($data_inicio_completa, "H:i");
			$data_inicio = date_format($data_inicio_completa, "d/m/Y");
			$data_inicio_completa = date_format($data_inicio_completa, "Y-m-d H:i:s");

			array_push($todosQuestionarios, array(
				"quest_nome" => $linha2["quest_nome"],
				"quest_codigo" => $linha2["quest_codigo"],
				"quest_materia" => $linha2["materia_nome"],
				"quest_numPerguntas" => $linha2["quest_numPerguntas"],
				"quest_tempo" => $linha2["quest_tempo"],
				"turma" => $linha2["turma_codigo"],
				"data_inicio" => $data_inicio." às ".$hora_inicio,
				"data_fim" => $data_fim." às ".$hora_fim,
				"data_inicio_completa" => $data_inicio_completa,
				"data_fim_completa" => $data_fim_completa,
				"prof_nome" => $linha2["user_nome"],
				"prof_sobrenome" => $linha2["professor_sobrenome"],
			));
		}
	}

	//Seleciona questionários já respondidos pelo usuário.
	$query = "SELECT distinct quest_codigo, data_resposta, turma_codigo FROM questionario_aluno WHERE user_email='".$_SESSION["user_email"]."';";
	$respondidos = $conexao->executaComando($query);

	//Separa questionários ainda não respodidos dos que já foram
	for($i = 0; $i < count($todosQuestionarios); $i++){
		$respondido = "não";
		
		//Reseta o contador do mysql_fetch_array para poder percorrer ele denovo
		mysqli_data_seek($respondidos, 0);

		while($linha = mysqli_fetch_array($respondidos)){	
			if(($todosQuestionarios[$i]["quest_codigo"] == $linha["quest_codigo"]) && 
			   ($todosQuestionarios[$i]["turma"] == $linha["turma_codigo"]) && 
			   ($linha["data_resposta"] < $todosQuestionarios[$i]["data_fim_completa"]) && 
			   ($linha["data_resposta"] > $todosQuestionarios[$i]["data_inicio_completa"])){

				   $respondido = "sim";
			}
		}

		//Adiciona questionários disponíveis para resposta no array $questionariosDisponiveis
		if($respondido == "não"){
			array_push($questionariosDisponiveis, $todosQuestionarios[$i]);
		}
	}

	//Envia informações do array $questionariosDisponiveis para a página de exibição de questionários
	if(count($questionariosDisponiveis) != 0){
		echo json_encode($questionariosDisponiveis);
	}else{
		echo json_encode(0);
	}
?>