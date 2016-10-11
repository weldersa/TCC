<?php
	//Imports
	require_once "../classes/conexao.class.php";
	
	//Inicia a seção
	session_start();

	$conexao = new Conexao();
	$questionarios = array();
	$contador = 0; //Serve para contar execução do while
	$query = "SELECT * FROM questionarios INNER JOIN materias ON questionarios.quest_materia=materias.materia_codigo WHERE quest_professor='".$_SESSION["user_email"]."';";

	$resultado = $conexao->executaComando($query);

	if(mysqli_num_rows($resultado) != 0){
		while($linha = mysqli_fetch_array($resultado)){
			$questionarios[$contador] = array(
				"quest_codigo" => $linha["quest_codigo"],
				"quest_nome" => $linha["quest_nome"],
				"quest_professor" => $linha["quest_professor"],
				"quest_materia" => $linha["materia_nome"],
				"quest_numPerguntas" => $linha["quest_numPerguntas"],
				"quest_tempo" => $linha["quest_tempo"],
				"quest_visualizar_resposta" => $linha["quest_visualizar_resposta"],
				"quest_randomiza_perguntas" => $linha["quest_randomiza_perguntas"],
				"quest_necessita_correcao" => $linha["quest_necessita_correcao"],
			);

			$contador++;
		}
		echo json_encode($questionarios);
	}else{
		echo json_encode(0);
	}	
?>