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
	$dataResposta = $_POST["data_resposta"];

	//Cria vetores que armazenam as perguntas, alternativas e ordem de apresentação desse questionário
	$ordemPerguntas = array();
	$todasPerguntas = array();
	$todasAlternativas = array();
	$respostasAluno = array();

	//Serve para apresentar as letras na frente das alternativas
	$alternativasLetras = array("A","B","C","D","E","F");

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

	//Busca data de aplicação do questionario

	//Busca respostas do aluno no banco e a armazena em um vetor
	$query = "SELECT * FROM questionario_aluno WHERE user_email = '".$_SESSION['user_email']."' AND quest_codigo = ".$questionario->getCodigo()." AND turma_codigo = ".$_POST["quest_turma"]." AND data_resposta = '".$dataResposta."';";
	$respostas = $conexao->executaComando($query);


	$contador = 0;
	while($linha = mysqli_fetch_array($respostas)){
		switch($todasPerguntas[$contador]->getTipo()){
			case "A":
			case "D":
				array_push($respostasAluno, $linha["resposta_ad"]);
				break;
			case "V":
				array_push($respostasAluno, $linha["resposta_vf"]);
				break;
		}

		$contador++;
	}
?>

<html lang="pt-BR">
    <head>
        <title>Visualizar Respostas</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP
			include 'menu.php';
		?>
		
		<div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="container-fluid">
				<div class="row">
                    <div class="col-md-12">
						<h3><?php echo $questionario->getNome(); ?></h3>
					</div>
                </div> <!-- Row End -->
				<br>
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
									echo "<center><img src='".$todasPerguntas[$i]->getImagem()."' id='img_preview_2' alt='Imagem da Pergunta' class='img-thumbnail'></img><br></center>";
								echo "</div>";
							}
							

							//Teste de tipo de Pergunta
							switch($todasPerguntas[$i]->getTipo()){
								case "A":
									if($respostasAluno[$i] != null){
										echo "<center><br> <b>SUA RESPOSTA: </b> ".$alternativasLetras[($respostasAluno[$i] - 1)]."</center>";
									}else{
										echo "<center><br> <b>SUA RESPOSTA: </b> Você não respodeu essa pergunta.</center>";
									}
								
									for($j = 1; $j <= $todasPerguntas[$i]->getNumAlternativas(); $j++){									
										$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($j);
										
										if($respostasAluno[$i] == $j){
											if($alternativa["correta"] == 1){
												$classe = "resposta_correta";
											}else{
												$classe = "resposta_incorreta";
											}

											$bold="bold";
										}else{
											$classe="";
											$bold="";
										}

										echo "<div class='radio pergunta_radio'><span class='".$bold."'>".$alternativasLetras[($j -1)]." - ".$alternativa["texto"]."</span></div>";

									}
									break;
								case "V":
									$respostas = array();
									$respostas = explode(";", $respostasAluno[$i]);
									$respostasVF = array();

									for($z = 0; $z < count($respostas); $z++){
										if($respostas[$z] == 0){
											$respostasVF[$z] = "F";
										}else{
											$respostasVF[$z] = "V";
										}
									}

									echo "<center><br> <b>SUA RESPOSTA: </b>".implode(";", $respostasVF)."</center>";

									for($j = 1; $j <= $todasPerguntas[$i]->getNumAlternativas(); $j++){
										$alternativa = $todasAlternativas[$todasPerguntas[$i]->getNumPergunta()]->getAlternativa($j);
										
										if($respostas[$j-1] == $alternativa["correta"]){
											$classe = "resposta_correta";
										}else{
											$classe = "resposta_incorreta";
										}

										
										echo "<div class='checkbox'><input type='text' value='".$respostasVF[($j-1)]."'class='txt_resposta_vf bold' readonly/><span class=''>".$alternativa["texto"]."</span></div>";

									}
									break;
								case "D":
									if($respostasAluno[$i] != null){
										echo "<br><br> <b>SUA RESPOSTA = </b> ".$respostasAluno[$i];
									}else{
										echo "<br><br> <b>SUA RESPOSTA = </b> Você não respodeu essa pergunta.";
									}

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
	</body>
</html>