<!--
DATA: 10/10/16
ARQUIVO: apresenta_resultado.php
DESCRIÇÃO: Calcula nota do aluno e salva as respostas no banco
-->

<!DOCTYPE html>
<?php
	//Imports
	require_once "classes/conexao.class.php";
	require_once "classes/questionario.class.php";
	require_once "classes/pergunta.class.php";
	require_once "classes/pergunta_alternativa.class.php";

	// Inicia a Sessão
	session_start();

	$questionario = new questionario();
	$conexao = new Conexao();

	//Vetor onde serão salvas as respostas do aluno
	$respostasDoAluno = array();

	//Data e hora atual
    date_default_timezone_set("America/Sao_Paulo");
    $dataAtual = date('Y-m-d H:i:s');
    
    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

	if( $_SERVER['REQUEST_METHOD'] == 'POST'){
		$questionario = unserialize($_SESSION["questionario"]);
		$todasPerguntas = unserialize($_SESSION["todasPerguntas"]);
		$todasAlternativas = unserialize($_SESSION["todasAlternativas"]);
		$quest_turma = $_POST["quest_turma"];

	}else{
		header('location: error.php');
	}

	for($i = 0; $i < $questionario->getNumPerguntas(); $i++){			
		//Teste de tipo de Pergunta
		switch($todasPerguntas[$i]->getTipo()){
			case "A":	
				if(isset($_POST["perg_".($i + 1)])){
					//Testa se acertou
					$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($_POST["perg_".($i + 1)]);
					if($alternativa["correta"] == 1){
						//acertou
						$nota = $todasPerguntas[$i]->getPeso();
					}else{
						//errou
						$nota = 0;
					}

					//Salva resposta do aluno e a nota obtida nessa pergunta
					$respostasDoAluno[$i] = array(
						"resposta" => $_POST["perg_".($i + 1)],
						"valorObtido" => $nota,
					);
				}else{
					//Salva resposta do aluno e a nota obtida nessa pergunta
					$respostasDoAluno[$i] = array(
						"resposta" => "",
						"valorObtido" => 0,
					);
				}											
				break;


			case "V":
				$resposta = array();
				$nota = 0;

				//Verifica respostas e nota obtida na pergunta
				for($j = 1; $j <= $todasPerguntas[$i]->getNumAlternativas(); $j++){
					if(isset($_POST["chk_perg_".($i + 1)."_alt_".$j])){
						//Testa se acertou
						$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($j);
						if($alternativa["correta"] == 1){
							//acertou
							$nota = $nota + ($todasPerguntas[$i]->getPeso() / $todasPerguntas[$i]->getNumAlternativas());
						}
						array_push($resposta, "1");
					}else{
						//Testa se acertou
						$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($j);
						if($alternativa["correta"] == 0){
							//acertou
							$nota = $nota + ($todasPerguntas[$i]->getPeso() / $todasPerguntas[$i]->getNumAlternativas());
						}
						array_push($resposta, "0");
					}
				}

				//Transforma vetor em string para salvar no banco depois
				$resposta = implode(";", $resposta);

				$respostasDoAluno[$i] = array(
					"resposta" => $resposta,
					"valorObtido" => $nota,
				);
				break;
			case "D":
				if($_POST["txt_resposta_".($i + 1)] != ""){
					$respostasDoAluno[$i] = $_POST["txt_resposta_".($i + 1)];
				}else{
					$respostasDoAluno[$i] = "";
				}									
				break;
		}
	}


	//Insere Respostas e nota final no banco de dados
	$count = 0;
	foreach($respostasDoAluno as $item){
		
		switch($todasPerguntas[$count]->getTipo()){
			case "A":
				$query = "INSERT INTO questionario_aluno (user_email, quest_codigo, perg_codigo, data_resposta, resposta_ad, turma_codigo, nota) VALUES('".$_SESSION["user_email"]."', ".$questionario->getCodigo().", ".$todasPerguntas[$count]->getCodigo().",'".$dataAtual."', '".$item["resposta"]."', ".$quest_turma.", ".$item["valorObtido"].");";
				break;
			case "V":
				$query = "INSERT INTO questionario_aluno (user_email, quest_codigo, perg_codigo, data_resposta, resposta_vf, turma_codigo, nota) VALUES('".$_SESSION["user_email"]."', ".$questionario->getCodigo().", ".$todasPerguntas[$count]->getCodigo().",'".$dataAtual."', '".$item["resposta"]."', ".$quest_turma.", ".$item["valorObtido"].");";
				break;
		}
		$conexao->executaComando($query);
		$count++;
	}

	$notaTotal = 0;
	foreach ($respostasDoAluno as $item) {
		$notaTotal += $item["valorObtido"];
	}

	$query = "INSERT INTO notas VALUES (".$notaTotal.", ".$questionario->getCodigo().", '".$_SESSION["user_email"]."', '".$dataAtual."');";
	$conexao->executaComando($query);
?>

<html lang="pt-BR">
    <head>
        <title>Pagina Principal</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página --> 
			<div class="container-fluid" id="opcao_pergunta">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <center><img src="resources/images/concluindo.png"></center>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <center>
							<b>Repostas Salvas com sucesso!</b>
							<br>
							Sua nota foi: <br>
							<span id="span_nota"><?php echo $notaTotal;?></span>
						</center>
                    </div>
                </div>
			</div>
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
        	//Muda o Link Ativo no Menu lateral
            $("#responderQuestionarios").addClass("active"); 
            $("#home").removeClass("active");                
        </script>            
    </body>
</html>    