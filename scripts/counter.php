<?php
	//Arquivo para realizar a contagem do número de questionários criados, pendentes, disponíveis, número de alunos cadastrados, número de professores e número de turmas

	//Inicia a seção
	session_start();

	//Imports
	require_once "../classes/conexao.class.php";

	//Instancia objetos
	$conexao = new Conexao();

	switch($_POST["operacao"]){
		case "quests_criados":
			echo json_encode(questCriados());
			break;
		case "quests_aplicados":
			echo json_encode(questAplicados());
			break;
		case "quests_nao_aplicados":
			echo json_encode(questNaoAplicados());
			break;
		case "contaAlunos":
			echo json_encode(contaAlunos());
			break;
		case "contaProfessor":
			echo json_encode(contaProfessor());
			break;
		case "contaTurmas":
			echo json_encode(contaTurmas());
			break;
	}

	function questCriados(){
		$query = "SELECT DISTINCT quest_codigo FROM questionarios WHERE quest_professor = '".$_SESSION['user_email']."';";
		$questsCriados = $GLOBALS["conexao"]->executaComando($query);

		return mysqli_num_rows($questsCriados);
	}

	function questAplicados(){
		$query = "SELECT DISTINCT questionario_turma.quest_codigo FROM questionario_turma INNER JOIN questionarios WHERE questionarios.quest_professor = '".$_SESSION['user_email']."';";
		$questsAplicados = $GLOBALS["conexao"]->executaComando($query);

		return mysqli_num_rows($questsAplicados);
	}

	function questNaoAplicados(){
		$query = "SELECT DISTINCT quest_codigo FROM questionarios WHERE quest_professor = '".$_SESSION['user_email']."';";
		$questsCriados = $GLOBALS["conexao"]->executaComando($query);

		$criados = mysqli_num_rows($questsCriados);
		
		$query = "SELECT DISTINCT questionario_turma.quest_codigo FROM questionario_turma INNER JOIN questionarios WHERE questionarios.quest_professor = '".$_SESSION['user_email']."';";
		$questsAplicados = $GLOBALS["conexao"]->executaComando($query);

		$aplicados = mysqli_num_rows($questsAplicados);

		return ($criados - $aplicados);
	}

	function contaAlunos(){
		$query = "SELECT DISTINCT aluno_email FROM alunos WHERE aluno_instituicao = ".$_SESSION["inst_codigo"].";";
		$alunos = $GLOBALS["conexao"]->executaComando($query);

		return mysqli_num_rows($alunos);
	}

	function contaProfessor(){
		$query = "SELECT DISTINCT professor_email FROM professores WHERE professor_instituicao = ".$_SESSION["inst_codigo"].";";
		$professores = $GLOBALS["conexao"]->executaComando($query);

		return mysqli_num_rows($professores);
	}

	function contaTurmas(){
		$query = "SELECT DISTINCT turma_codigo FROM turmas WHERE turma_instituicao=".$_SESSION["inst_codigo"].";";
		$turmas = $GLOBALS["conexao"]->executaComando($query);

		return mysqli_num_rows($turmas);
	}
?>