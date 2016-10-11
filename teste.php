<!DOCTYPE html>

<?PHP
    //Imports
    require_once "classes/questionario.class.php";
    require_once "classes/pergunta.class.php";
    require_once "classes/pergunta_alternativa.class.php";

    //Inicia a sessão
    session_start();

	$questionario = new Questionario();
    $questionario = unserialize($_SESSION["questionario"]);

	$perguntas = new Pergunta();
	$perguntas = unserialize($_SESSION["perguntas"]);

	$perguntas_alternativas = new Pergunta_alternativa();
    $perguntas_alternativas = unserialize($_SESSION["perguntas_alternativas"]);
?> 

<html>
	<head>
		<title>Teste</title>
	</head>
	<body>
		<?PHP
			echo "<b>Nome do Questionário:</b> ".$questionario->getNome();
			echo "<br>";
			echo "<b>Criado por: </b>".$_SESSION["user_email"];
			echo "<br>";
			echo "<b>Matéria do Questionário:</b> ".$questionario->getMateria();
			echo "<br>";
			echo "<b>Tempo para Responder:</b> ";
			$tempo = $questionario->getTempo();
			if ($tempo == ""){
				echo "Sem tempo para responder";
			}else{
				echo $tempo." Minutos";
			}
			echo "<br>";
			if($questionario->getVisualizaResposta()){
				$resposta = "Sim";
			}else{
				$resposta = "Não";
			}
			echo "<b>Permite visualizar resposta após resolução:</b> ".$resposta;
			echo "<br>";
			if($questionario->getRandomizarPerguntas()){
				$resposta = "Sim";
			}else{
				$resposta = "Não";
			}
			echo "<b>Apresenta as perguntas de forma randomizada:</b> ".$resposta;
			echo "<br>";
			echo "<b>Número de perguntas: </b>".$_SESSION["numPerguntas"];
			echo "<br><br>";
			echo "<hr/>";

			for($i = 1; $i <= $_SESSION["numPerguntas"]; $i++){
				echo "<br>";
				echo "<b><font color='red'>Pergunta ".$i.":</b></font>";
				echo "<br><br>";
				echo "<b>Tipo: </b>".$perguntas[$i]->getTipo();
				echo "<br>";
				echo "<b>Peso da Pergunta: </b>".$perguntas[$i]->getPeso();
				echo "<br>";
				echo "<b>Tags: </b>";

				$tags = $perguntas[$i]->getTags();

				for ($j = 0; $j < count($tags); $j++){
					if ($j == 0){
						echo $tags[$j];
					}else{
						echo ", ".$tags[$j];
					}
				}
				echo ".";

				echo "<br><br>";
				echo "<b>Enunciado:</b>";
				echo "<br>";
				echo $perguntas[$i]->getEnunciado();
				echo "<br><br>";
				
				

				if(($perguntas[$i]->getTipo() == "Alternativa") OR ($perguntas[$i]->getTipo() == "Verdadeiro/Falso")){
					for($j = 1; $j <= $perguntas[$i]->getNumAlternativas(); $j++){
						$alternativaAtual = $perguntas_alternativas[$i]->getAlternativa($j);
						echo "<b>Alternativa ".$j.":</b>";
						echo "<br>";
						echo $alternativaAtual["texto"];
						echo "<br><br><br>";
					}
					echo "<b>Alternativa(s) Correta(s): </b>";
					for($j = 1; $j <= $perguntas[$i]->getNumAlternativas(); $j++){
						$alternativaAtual = $perguntas_alternativas[$i]->getAlternativa($j);
						if($alternativaAtual["correta"]){
							if ($j == 1){
								echo $j;
							}else{
								echo ", ".$j;
							}
						}
					}
					echo ".";						
				}
				echo "<hr/>";
			}
		?>
	</body>
</html>