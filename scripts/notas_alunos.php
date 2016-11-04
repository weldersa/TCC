<?php
	//Imports
	require_once "../classes/conexao.class.php";
	
	//Inicia a seção
	session_start();

	//Data e hora atual
    date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');

	$tipo_busca = $_POST['slc_opcaoBusca'];
	$txt_busca = $_POST['txt_busca'];

	$conexao = new Conexao();
	$alunos = array();

	$contador = 0; //Serve para contar execução do while

	if($_SESSION['user_tipo'] == 'A'){
		$query = "SELECT distinct questionario_aluno.user_email, questionario_aluno.data_resposta, questionarios.quest_nome, usuarios.user_nome, professores.professor_sobrenome, notas.nota_valor, notas.`data`, materias.materia_nome FROM questionario_aluno INNER JOIN questionarios ON questionario_aluno.quest_codigo=questionarios.quest_codigo INNER JOIN materias ON materias.materia_codigo=questionarios.quest_materia INNER JOIN usuarios ON usuarios.user_email=questionarios.quest_professor INNER JOIN professores ON professores.professor_email=questionarios.quest_professor INNER JOIN turmas ON turmas.turma_codigo=questionario_aluno.turma_codigo INNER JOIN notas ON notas.quest_codigo=questionario_aluno.quest_codigo WHERE $tipo_busca LIKE '%$txt_busca%';";

		$resultado = $conexao->executaComando($query);

		if(mysqli_num_rows($resultado) != 0){
			while($linha = mysqli_fetch_array($resultado)){

				$data_resposta_completa = date_create($linha["data_resposta"]);
				$hora_resposta = date_format($data_resposta_completa, "H:i");
				$data_resposta = date_format($data_resposta_completa, "d/m/Y");
				$data_resposta_completa = date_format($data_resposta_completa, "Y-m-d H:i:s");

				$questionarios[$contador] = array(
					"quest_nome" => $linha["quest_nome"],
					"quest_professor" => $linha["user_nome"],
					"quest_materia" => $linha["materia_nome"],
					"data_resposta" => $data_resposta." ".$hora_resposta,
					"nota_valor" => $linha['nota_valor'],
				);

				$contador++;
			}
			echo json_encode($questionarios);
		}else{
			echo json_encode(0);
		}
	}
	if($_SESSION['user_tipo'] == 'P'){
		$query = ("SELECT distinct concat (usuarios.user_nome, ' ', alunos.aluno_sobrenome) as nome_aluno, usuarios.user_nome, alunos.aluno_sobrenome, questionarios.quest_nome, questionario_aluno.data_resposta, notas.nota_valor, turmas.turma_nome, materias.materia_nome FROM questionario_aluno INNER JOIN usuarios ON usuarios.user_email=questionario_aluno.user_email INNER JOIN alunos ON alunos.aluno_email=usuarios.user_email INNER JOIN questionarios ON questionarios.quest_codigo=questionario_aluno.quest_codigo INNER JOIN professores ON professores.professor_email=questionarios.quest_professor INNER JOIN notas ON notas.quest_codigo=questionario_aluno.quest_codigo INNER JOIN turmas ON turmas.turma_codigo=questionario_aluno.turma_codigo INNER JOIN materias ON materias.materia_codigo=questionarios.quest_materia	WHERE $tipo_busca like '%$txt_busca%';");
		$resultado = $conexao->executaComando($query);

		if(mysqli_num_rows($resultado) != 0){
			while($linha = mysqli_fetch_array($resultado)){

				$data_resposta_completa = date_create($linha["data_resposta"]);
				$hora_resposta = date_format($data_resposta_completa, "H:i");
				$data_resposta = date_format($data_resposta_completa, "d/m/Y");
				$data_resposta_completa = date_format($data_resposta_completa, "Y-m-d H:i:s");

				$questionarios[$contador] = array(
					"quest_aluno" => $linha["user_nome"],
					"aluno_sobrenome" => $linha['aluno_sobrenome'],
					"quest_nome" => $linha["quest_nome"],
					"quest_materia" => $linha["materia_nome"],
					"turma_nome" => $linha["turma_nome"],
					"data_resposta" => $data_resposta." ".$hora_resposta,
					"nota_valor" => $linha["nota_valor"],
				);

				$contador++;
			}
			echo json_encode($questionarios);
		}else{
			echo json_encode(0);
		}
	}

						//------------------------------------------CORRIGIR ABAIXO
	if($_SESSION['user_tipo'] == 'I'){
		$query = ("SELECT distinct usuarios.user_nome, alunos.aluno_sobrenome, questionarios.quest_nome, notas.`data`, notas.nota_valor, 
		turmas.turma_nome, materias.materia_nome FROM questionario_aluno INNER JOIN usuarios ON usuarios.user_email=questionario_aluno.user_email INNER JOIN alunos ON alunos.aluno_email=usuarios.user_email INNER JOIN questionarios ON questionarios.quest_codigo=questionario_aluno.quest_codigo INNER JOIN professores ON professores.professor_email=questionarios.quest_professor INNER JOIN notas ON notas.quest_codigo=questionario_aluno.quest_codigo INNER JOIN turmas ON turmas.turma_codigo=questionario_aluno.turma_codigo INNER JOIN materias ON materias.materia_codigo=questionarios.quest_materia WHERE professores.professor_email = '$_SESSION[user_email]'");
		$resultado = $conexao->executaComando($query);

		if(mysqli_num_rows($resultado) != 0){
			while($linha = mysqli_fetch_array($resultado)){

				$data_resposta_completa = date_create($linha["data_resposta"]);
				$hora_resposta = date_format($data_resposta_completa, "H:i");
				$data_resposta = date_format($data_resposta_completa, "d/m/Y");
				$data_resposta_completa = date_format($data_resposta_completa, "Y-m-d H:i:s");

				$questionarios[$contador] = array(
					"quest_aluno" => $linha["user_nome"],
					"quest_aluno_sobrenome" => $linha["aluno_sobrenome"],
					"quest_nome" => $linha["quest_nome"],
					"quest_materia" => $linha["materia_nome"],
					"turma_nome" => $linha["turma_nome"],
					"data_resposta" => $data_resposta." ".$hora_resposta,
					"nota_valor" => $linha["nota_valor"],
				);

				$contador++;
			}
			echo json_encode($questionarios);
		}else{
			echo json_encode(0);
		}
	}
	
?>