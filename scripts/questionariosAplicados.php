<?php
	//Imports
	require_once "../classes/conexao.class.php";
	
	//Inicia a seção
	session_start();

	//Data e hora atual
    date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');
	//$dataAtual = "2016-08-13 18:04:23"; - Só pra teste

	$conexao = new Conexao();
	$questionarios = array();
	$contador = 0; //Serve para contar execução do while

	$query = "SELECT * FROM questionarios INNER JOIN questionario_turma ON questionarios.quest_codigo=questionario_turma.quest_codigo INNER JOIN materias ON questionarios.quest_materia=materias.materia_codigo WHERE quest_professor='".$_SESSION["user_email"]."' AND questionario_turma.data_fim > '".$dataAtual."';";

	$resultado = $conexao->executaComando($query);

	//Serve para marcar quais questionários já foram mostrados, para caso um quest esteja aplicado mais de uma vez, não ser duplicado na página.
	$apresentados = array();

	if(mysqli_num_rows($resultado) != 0){
		while($linha = mysqli_fetch_array($resultado)){

			$mostrado = false;

			if(count($apresentados) != 0){
				for ($i=0; $i < count($apresentados); $i++){
					if ($linha["quest_codigo"] == $apresentados[$i]){
						$mostrado = true;
					}
				}
			}
			

			if($mostrado == false){
				$questionarios[$contador] = array(
					"quest_codigo" => $linha["quest_codigo"],
					"quest_nome" => $linha["quest_nome"],
					"quest_materia" => $linha["materia_nome"],
					"quest_numPerguntas" => $linha["quest_numPerguntas"],
					"quest_tempo" => $linha["quest_tempo"],
					"quest_visualizar_resposta" => $linha["quest_visualizar_resposta"],
					"quest_randomiza_perguntas" => $linha["quest_randomiza_perguntas"],
					"quest_necessita_correcao" => $linha["quest_necessita_correcao"],
				);

				$contador++;
				array_push($apresentados, $linha["quest_codigo"]);
			}			
		}
		echo json_encode($questionarios);
	}else{
		echo json_encode(0);
	}	
?>