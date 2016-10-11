<?php

	if( $_SERVER['REQUEST_METHOD'] == 'POST'){

		require_once '../classes/conexao.class.php';
		$conexao = new Conexao();

		$txtBusca = $_POST["txt_busca"];
		$opcaoBusca = $_POST["slc_opcaoBusca"];
		$data = array();

		switch($_POST["slc_opcaoBusca"]){
			case "Enunciado":
				$query = "SELECT perg_enunciado, perg_tipo, perg_peso, perg_codigo FROM perguntas where perg_enunciado  LIKE '%".$txtBusca."%';";
				break;
			
			case "Materia":
			case "Palavra-chave";
				$query = "SELECT DISTINCT perguntas.perg_enunciado, perguntas.perg_tipo, perguntas.perg_peso, perguntas.perg_codigo FROM perguntas INNER JOIN tags ON perguntas.perg_codigo=tags.perg_codigo WHERE tags.perg_tag LIKE '%".$txtBusca."%' LIMIT 100;";
				break;
		}

		$resultado = $conexao->executaComando($query) or die("ERRO : ".$query);
		

		if(mysqli_num_rows($resultado) != 0){
			while ($linha = mysqli_fetch_array($resultado)){
				$enunciado = substr($linha["perg_enunciado"], 0, 220);
				if (strlen($enunciado) >= 220){
					$enunciado = $enunciado." [...]";
				}

				switch($linha["perg_tipo"]){
					case "A":
						$tipo = "Alternativa";
						break;
					case "V":
						$tipo = "Verd./Falso";
						break;
					case "D":
						$tipo = "Dissertativa";
						break;
				}

				$pergunta_atual = array(
					"enunciado" => $enunciado,
					"tipo" => $tipo,
					"peso" => $linha["perg_peso"],
					"codigo" => $linha["perg_codigo"],
				);


				array_push($data, $pergunta_atual);
			}

			echo json_encode($data);
		}else{
			echo json_encode(0);
		}
	}
?>