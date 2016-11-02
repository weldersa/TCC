<!--
DATA: 27/06/16    
ARQUIVO: peso_perguntas.php
DESCRIÇÃO: Página para atribuir o peso das perguntas
-->


<!DOCTYPE html>
<?php
	//Imports
    require_once "classes/questionario.class.php";
    require_once "classes/pergunta.class.php";
    require_once "classes/pergunta_alternativa.class.php";

	// Inicia a Sessão
	session_start();

	if($_SESSION["user_tipo"] != "P"){
        header('location: permission_denied.php'); 
    }	
    
    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

	$questionario = new Questionario();
    $questionario = unserialize($_SESSION["questionario"]);
	$perguntas = new Pergunta();
	$perguntas = unserialize($_SESSION["perguntas"]);
	$perguntas_alternativas = new Pergunta_alternativa();
    $perguntas_alternativas = unserialize($_SESSION["perguntas_alternativas"]);

	$pesoDividido = 100 / $_SESSION["numPerguntas"];

	$pesoTotal = $pesoDividido * $_SESSION["numPerguntas"];

	if( $_SERVER['REQUEST_METHOD'] == 'POST'){
		 
		if($_POST["opcao_peso"] == "opt1"){ //Atribui o peso automaticamente
			$peso = 100 / $_SESSION["numPerguntas"];

			for($i = 1; $i <= $_SESSION["numPerguntas"]; $i++){
				$perguntas[$i]->setPeso(round($peso,3));	
			}

		}else{ // Atribui o peso personalizado pelo user
			for($i = 1; $i <= $_SESSION["numPerguntas"]; $i++){
				$perguntas[$i]->setPeso($_POST["txtPesoPergunta".$i]);	
			}

		}

		if($_POST["permitir_resposta"] == "nao"){
			$questionario->setVisualizaResposta(0);
		}else{
			$questionario->setVisualizaResposta(1);
		}

		if($_POST["randomizar_perguntas"] == "nao"){
			$questionario->setRandomizarPerguntas(0);
		}else{
			$questionario->setRandomizarPerguntas(1);
		}

		//Salva o questionário e as perguntas atualizadas na seção
		$_SESSION["questionario"] = serialize($questionario);
		$_SESSION["perguntas"] = serialize($perguntas);

    	header("Location: conclui_questionario.php");   
    }
?>

<html lang="pt-BR">
    <head>
        <title>Finalizar Questionário</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP 
			include 'menu.php';
			//Atribui o número de perguntas já criadas para que possa ser usado no javascript
            echo '<input type="hidden" name="txtNumPergunta" id="txtNumPergunta" value="'.$_SESSION['numPerguntas'].'">'; 
		?>
        
        <div class="container">
		<form id="form_extra" method="POST" target="_self">
		   <div id="pergunta_peso">
		   		<h3>Mais Opções:</h3>
		   		<br>
				<b>Atribuir um peso personalisado às perguntas ou deixar que o sistema calcule o peso dividindo 
				igualmente entre todas?</b>
				<br><br>
				<input type="radio" name="opcao_peso" id="opt1" value="opt1" checked> Atribuir peso automáticamente
				&nbsp;&nbsp;
				<input type="radio" name="opcao_peso" id="opt2" value="opt2"> Personalizar peso das perguntas
				<br><br>
				<b>Permitir que os alunos visualizem as respostas corretas após a resolução do questionário?</b>
				<br><br>
				<input type="radio" name="permitir_resposta" id="nao" value="nao" checked> Não
				&nbsp;&nbsp;
				<input type="radio" name="permitir_resposta" id="sim" value="sim"> Sim
				<br><br>
				<b>Randomizar a ordem das perguntas durante a aplicação do questionário?</b>
				<br><br>
				<input type="radio" name="randomizar_perguntas" id="nao" value="nao" checked> Não
				&nbsp;&nbsp;
				<input type="radio" name="randomizar_perguntas" id="sim" value="sim"> Sim
				<br><br>
				<div class="pull-right">    
					<input type="button" class="btn btn-danger" id="btn_voltar"value="Voltar"/>                                                        
                	<input type="button" class="btn btn-success" id="btn_finalizaQuest" value="Finalizar Questionário"/>
                </div>
				  
		   </div>
		   <div id="div_perguntas">
		   		<h3>Atribuir Peso às Perguntas:</h3>
		   		<br>
				<table>
					<thead>
						<tr>
							<th>Nº</th>
							<th>Título Pergunta</th>
							<th>Peso</th>
						</tr>
					</thead>
					<tbody>
						<?php
							for($i=1; $i <= $_SESSION["numPerguntas"]; $i++){
								$enunciado = substr($perguntas[$i]->getEnunciado(), 0, 65);
								if (strlen($enunciado) >= 65){
									$enunciado = $enunciado." [...]";
								}

								echo '
									<tr>
										<td>'.($i).'</td>
										<td>'.$enunciado.'</td>
										<td><input value="'.$pesoDividido.'" type="text" class="pesoPergunta" id="txtPesoPergunta'.$i.'" name="txtPesoPergunta'.$i.'"/></td>
									</tr>
								';
							}
						?>
					</tbody>
				</table>
				<br>
				<div id="div_pesoTotal" class="pull-right">
					Peso Total:
					<?php echo '<input type="text" id="txtPesoTotal" value="'.$pesoTotal.'" />';?>
				</div>
				<br><br>
				<div class="pull-right">    
					<input type="button" class="btn btn-danger" id="btn_voltar2"value="Voltar"/>
					<input type="button" class="btn btn-success" id="btn_finalizaQuest2"value="Finalizar Questionário"/>					                                                        
                </div>
		   </div>
		   </form>
        </div>
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");

			$(document).ready(function(){
				$("#btn_finalizaQuest").click(function(){
					if($('input[name="opcao_peso"]:checked').val() == "opt1"){
						$("#form_extra").submit();
					}else{
						$("#pergunta_peso").hide();
						$("#div_perguntas").show();
					}					
				});

				$("#btn_finalizaQuest2").click(function(){
					$("#form_extra").submit();
				});

				$(".pesoPergunta").on('input', function(){
					var total = 0;
					for(i = 1; i <= $("#txtNumPergunta").val(); i++){
						total = total + parseInt($("#txtPesoPergunta"+i).val());
					}

					$("#txtPesoTotal").val(total);

					if(total > 100){
						$("#txtPesoTotal").removeClass("success");
						$("#txtPesoTotal").addClass("error");

					}else if(total == 100){
						$("#txtPesoTotal").addClass("success");
						$("#txtPesoTotal").removeClass("error");

					}else{
						$("#txtPesoTotal").removeClass("success");
						$("#txtPesoTotal").removeClass("error");
					}				
				});

				$('input[name="opcao_peso"]').change(function(){
					if($(this).val() == "opt1"){
						$("#btn_finalizaQuest").val("Finalizar Questionário");
					}else{
						$("#btn_finalizaQuest").val("Continuar");
					}
				});

				$("#btn_voltar").click(function(){
					window.history.back(-1);
				});

				$("#btn_voltar2").click(function(){
					$("#pergunta_peso").show();
					$("#div_perguntas").hide();
				});
			});
        </script>        
    </body>
</html>