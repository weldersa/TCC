<?php
	//Imports
	require_once "../classes/conexao.class.php";

	$conexao = new Conexao();

	//Recupera pergunta do banco
	$pergunta = $conexao->executaComando("SELECT * FROM perguntas WHERE perg_codigo=".$_POST["perg_codigo"]);

	
	if(mysqli_num_rows($pergunta) != 0){
		$resultado = mysqli_fetch_array($pergunta);

		//Salva atributos da pergunta nas variáveis abaixo
		$codigo = $resultado["perg_codigo"];
		$enunciado = $resultado["perg_enunciado"];
		$imagem = $resultado["perg_imagem"];
		$peso = $resultado["perg_peso"];
		$tipo = $resultado["perg_tipo"];
		$numAlternativas = $resultado["perg_numAlternativas"];

		$tags= array();

		$resultado = $conexao->executaComando("SELECT * FROM tags WHERE perg_codigo=".$codigo);

		$i = 0;

		while ($linha = mysqli_fetch_array($resultado)) {
			$tags[$i] = $linha["perg_tag"]; 
			$i++; 
		}

		$alternativas = array();

		if($tipo != "D"){
			$resultado = $conexao->executaComando("SELECT * FROM perguntas_alternativas WHERE perg_codigo=".$codigo);

			$i = 0;

			while($linha = mysqli_fetch_array($resultado)){
				$alternativas[$i]["perg_codigo"] = $linha["perg_codigo"];
				$alternativas[$i]["alternativa_texto"] = $linha["alternativa_texto"];
				$alternativas[$i]["alternativa_ordem"] = $linha["alternativa_ordem"];
				$alternativas[$i]["alternativa_correta"] = $linha["alternativa_correta"];
				$i++;
			}

			$data = array($tipo, $codigo, $enunciado, $imagem, $peso, $tags, $numAlternativas, $alternativas);
		}else{
			$data = array($tipo, $codigo, $enunciado, $imagem, $peso, $tags);
		}		

		echo json_encode($data);
	}else{
		return false;
	}


?>