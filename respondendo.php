<!--
DATA: 03/05/16    
ARQUIVO: respondendo.php
DESCRIÇÃO: Página onde o aluno responde o questionário
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

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

	//Instancia uma nova conexão
	$conexao = new Conexao();

	//Cria objeto "questionário" e busca suas informações no banco.
	$questionario = new Questionario();
	$questionario->consultaQuest($_POST["quest_codigo"]);

	//Cria vetores que armazenam as perguntas, alternativas e ordem de apresentação desse questionário
	$ordemPerguntas = array();
	$todasPerguntas = array();
	$todasAlternativas = array();

	//Recupera lista de perguntas e a ordem das mesmas do banco de dados.
	$query = "SELECT * FROM ordem_perguntas WHERE quest_codigo = ".$questionario->getCodigo().";";
	$resultado = $conexao->executaComando($query);

	while($linha = mysqli_fetch_array($resultado)){
		array_push($ordemPerguntas, array(
			"perg_codigo" => $linha["perg_codigo"],
			"perg_ordem" => $linha["perg_ordem"],
		));
	}

	//Busca as perguntas no banco e as armazena nos vetores.	
	for($i=0; $i<$questionario->getNumPerguntas(); $i++){
		$pergunta = new Pergunta();
		$pergunta->consultaPergunta($ordemPerguntas[$i]["perg_codigo"]);
		$pergunta->setNumPergunta($ordemPerguntas[$i]["perg_ordem"]);

		array_push($todasPerguntas, $pergunta);

		if($pergunta->getTipo() != "D"){
			$alternativas = new Pergunta_alternativa();
			$alternativas->consultaAlternativas($pergunta->getCodigo());

			$todasAlternativas[$ordemPerguntas[$i]["perg_ordem"]] = $alternativas;

			unset($alternativas);
		}

		unset($pergunta);
	}

	//Insere informações na sessão
	$_SESSION["questionario"] = serialize($questionario);
	$_SESSION["todasPerguntas"] = serialize($todasPerguntas);
	$_SESSION["todasAlternativas"] = serialize($todasAlternativas);

	$minutos = $_POST["quest_tempo"];
	//$minutos = 01;
	$segundos = 00;
?>

<html lang="pt-BR">
    <head>
        <title>Responder Questinário</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP
			include 'menu.php';
			
			//Verifica se o questionário tem tempo de resposta e se sim apresenta o contador
			if($_POST["quest_tempo"] != 0){
				echo "<div class='input-group' id='div_tempo_restante'>";
					echo "<span id='input-add-tempo' class='input-group-addon floating'>Tempo restante para responder:</span>";
					echo "<input type='text' id='tempo_restante' class='form-control' value='".sprintf('%02d', $minutos).":".sprintf('%02d', $segundos)."' readonly>";
					echo "<input type='hidden' id='minutos' value='".$minutos."'>";
					echo "<input type='hidden' id='segundos' value='".$segundos."'>";
				echo "</div>";
			}
		?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="container-fluid">
				<br>
				<div class="row">
                    <div class="col-md-12">
						<h3><?php echo $questionario->getNome(); ?></h3>
					</div>
                </div> <!-- Row End -->
				<br><br>

				<form method="POST" id="form_perguntas" action="apresenta_resultado.php">

					
					<!-- Apresenta as questões na tela -->
					<?php
						echo "<input type='hidden' name='quest_turma' value='".$_POST["quest_turma"]."'>";
						echo "<input type='hidden' name='quest_tempo' value='".$_POST["quest_tempo"]."'>";

						for($i = 0; $i < $questionario->getNumPerguntas(); $i++){
							echo "<div class='row'>";						

							if($i == 0){
								echo "<div class='div_mostra_pergunta div_mostra_pergunta_primeira'>";
							}else if($i == ($questionario->getNumPerguntas() - 1)){
								echo "<div class='div_mostra_pergunta div_mostra_pergunta_ultima'>";
							}else{
								echo "<div class='div_mostra_pergunta'>";
							}

							//Enunciado
							echo "<span id='pergunta_enunciado'>".$todasPerguntas[$i]->getNumPergunta()." - ".$todasPerguntas[$i]->getEnunciado()."</span>";
							echo "<br><br>";

							//Teste para verificar se tem imagem
							if($todasPerguntas[$i]->getImagem() != null){
								echo "<div class='div_imagem_pergunta'>";
									echo "<img src='".$todasPerguntas[$i]->getImagem()."' id='img_preview_2' alt='Imagem da Pergunta' class='img-thumbnail'></img><br>";
								echo "</div>";
							}


							//Teste de tipo de Pergunta
							switch($todasPerguntas[$i]->getTipo()){
								case "A":
									for($j = 1; $j <= $todasPerguntas[$i]->getNumAlternativas(); $j++){
										$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($j);
										echo "<div class='radio pergunta_radio'><input type='radio' value='".$j."' name='perg_".$todasPerguntas[$i]->getNumPergunta()."'>".$alternativa["texto"]."</label></div>";
									}
									break;
								case "V":
									echo "<span class='informacao'><center><i>Marque somente as alternativas verdadeiras</i></center></span>";
									for($j = 1; $j <= $todasPerguntas[$i]->getNumAlternativas(); $j++){
										$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($j);

										echo "<div class='checkbox'><label><input type='checkbox' name='chk_perg_".$todasPerguntas[$i]->getNumPergunta()."_alt_".$alternativa["ordem"]."' value='1' id='chk_perg_".$todasPerguntas[$i]->getNumPergunta()."_alt_".$alternativa["ordem"]."'>".$alternativa["texto"]."</div>";
									}
									break;
								case "D":
									echo "<textarea id='txt_resposta_".$todasPerguntas[$i]->getNumPergunta()."' name='txt_resposta_".$todasPerguntas[$i]->getNumPergunta()."' class='form-control' rows='5'></textarea>";
									break;
							}

							echo "</div></div>";
						}
					?>

					<br>
					<div class="row">
						<div id="div_botoes" class="col-md-12 col-xs-12">
							<!--<div class="pull-left">
								<input type="button" id="btn_anterior" class="btn btn-danger" value="Anterior"/>
							</div>-->
							<div class="pull-right">
								<input type="submit" id="btn_proxima" name="btn_proxima" class="btn btn-primary" value="Concluir"/>
							</div>
						</div>
					</div> <!-- Row End -->
				</form>
			</div>
		</div>
        
        <script> 
        	//Muda o Link Ativo no Menu lateral
            $("#responderQuestionarios").addClass("active"); 
            $("#home").removeClass("active");                
        </script>        
    </body>
</html>
<script>
	var timer = setInterval(function(){

		var minutos = $("#minutos").val();
		var segundos = $("#segundos").val();

		if(segundos == 00){
			segundos = 59;
			minutos = minutos - 1;
		}else{
			segundos = segundos - 1;
		}
		$("#minutos").val(minutos);
		$("#segundos").val(segundos);

		//formata os números para adicionar um zero na frente caso seja só de um digito
		if(segundos < 10){
			segundos = "0" + segundos;
		}

		//formata os números para adicionar um zero na frente caso seja só de um digito
		if(minutos < 10){
			minutos = "0" + minutos;
		}

		$('#tempo_restante').val(minutos + ":" + segundos);
		if(segundos == 0 && minutos == 0){
			$("#form_perguntas").submit();	
		}
	},1000);
</script>