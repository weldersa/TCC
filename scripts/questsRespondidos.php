<?php
	//Imports
	require_once "../classes/conexao.class.php";

	// Inicia a Sessão
	session_start();

	//Data e hora atual
    date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');

	$conexao = new Conexao();
	$questionariosRespondidos = array();

	//Seleciona questionários já respondidos pelo usuário.
	$query = "SELECT distinct questionario_aluno.quest_codigo, questionario_aluno.data_resposta, questionario_aluno.turma_codigo, questionarios.*, materias.materia_nome, usuarios.user_nome, professores.professor_sobrenome, turmas.turma_nome, turmas.turma_codigo FROM questionario_aluno INNER JOIN questionarios ON questionario_aluno.quest_codigo=questionarios.quest_codigo INNER JOIN materias ON materias.materia_codigo=questionarios.quest_materia INNER JOIN usuarios ON usuarios.user_email=questionarios.quest_professor INNER JOIN professores ON professores.professor_email=questionarios.quest_professor INNER JOIN turmas ON turmas.turma_codigo=questionario_aluno.turma_codigo WHERE questionario_aluno.user_email='".$_SESSION["user_email"]."';";
	//$query = "SELECT distinct quest_codigo, data_resposta, turma_codigo FROM questionario_aluno WHERE user_email='".$_SESSION["user_email"]."';";
	$respondidos = $conexao->executaComando($query);

	//echo $query;

	

	while($linha = mysqli_fetch_array($respondidos)){
		
		$data_resposta_completa = date_create($linha["data_resposta"]);
		$hora_resposta = date_format($data_resposta_completa, "H:i");
		$data_resposta = date_format($data_resposta_completa, "d/m/Y");
		$data_resposta_completa = date_format($data_resposta_completa, "Y-m-d H:i:s");

		array_push($questionariosRespondidos, array(
			"quest_nome" => $linha["quest_nome"],
			"quest_codigo" => $linha["quest_codigo"],
			"quest_materia" => $linha["materia_nome"],
			"quest_numPerguntas" => $linha["quest_numPerguntas"],
			"quest_tempo" => $linha["quest_tempo"],
			"turma" => $linha["turma_nome"],
			"turma_codigo" => $linha["turma_codigo"],
			"data_resposta" => $data_resposta." às ".$hora_resposta,
			"data_resposta_completa" => $data_resposta_completa,
			"prof_nome" => $linha["user_nome"],
			"prof_sobrenome" => $linha["professor_sobrenome"],
		));
	}

	if(count($questionariosRespondidos) != 0){
		echo json_encode($questionariosRespondidos);
	}else{
		echo json_encode(0);
	}
?>