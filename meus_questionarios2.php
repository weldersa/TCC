<!--
DATA: 03/05/16    
ARQUIVO: meus_questionarios.php
DESCRIÇÃO: Pagina que lista questionários criados pelo professor.
-->

<!DOCTYPE html>
<?php
	//Imports
    require_once "classes/questionario.class.php";		
	require_once "classes/conexao.class.php";

	// Inicia a Sessão
	session_start();
    
	if($_SESSION["user_tipo"] != "P"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

	$conexao = new Conexao();

	$resultado = $conexao->executaComando("SELECT * FROM questionarios INNER JOIN materias ON questionarios.quest_materia=materias.materia_codigo WHERE quest_professor='".$_SESSION["user_email"]."';");
	
	//Array onde serão armazendados os objetos Questionário recuperados do banco
	$questionarios = array();

	while($linha = mysqli_fetch_array($resultado)){

		$questionarioAtual = new Questionario();

		$questionarioAtual->setCodigo($linha["quest_codigo"]);
		$questionarioAtual->setNome($linha["quest_nome"]);
		$questionarioAtual->setProfessor($linha["quest_professor"]);
		$questionarioAtual->setMateria($linha["materia_nome"]);
		$questionarioAtual->setNumPerguntas($linha["quest_numPerguntas"]);
		$questionarioAtual->setTempo($linha["quest_tempo"]);
		$questionarioAtual->setVisualizaResposta($linha["quest_visualizar_resposta"]);
		$questionarioAtual->setRandomizarPerguntas($linha["quest_randomiza_perguntas"]);
		$questionarioAtual->setNecessitaCorrecao($linha["quest_necessita_correcao"]);

		array_push($questionarios, $questionarioAtual);
	}
?>

<html lang="pt-BR">
    <head>
        <title>Meus Questionários</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>

        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="container-fluid">
				<div class="row">
                    <div class="col-md-12 col-xs-12">
						<h3>Meus Questionários:</h3>
						<br>
                    </div>
                </div> <!-- Row End -->
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<center>
                        <div id="rb_tipo_pergunta" class="btn-group" data-toggle="buttons">
							<label id="lbl_todos" class="btn btn-primary active">
								<input type="radio" name="status_questionario" value="todos" id="cbx_todosQuests" autocomplete="off" checked="checked">Todos
							</label>
							<label id="lbl_aplicados" class="btn btn-primary">
								<input type="radio" name="status_questionario" value="aplicados" id="cbx_questsAplicados" autocomplete="off">Aplicados
							</label> 
							<label id="lbl_naoAplicados" class="btn btn-primary">
								<input type="radio" name="status_questionario" value="nao_aplicados" id="cbx_questsNaoAplicados" autocomplete="off">Não Aplicados
							</label>
						</div>
						</center>
                    </div>
				</div> <!-- Row End -->		
				<div class="row">
					<div class="col-md-12">
						<br><br>
						<div class="panel-group" id="panel_questionarios">
							<div id="panel_questionario" class="panel panel-default">
								<div id="panel_sem_questionarios" class='panel-heading div_panel'>
									<span> Não existem questionários criados </span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
			$(".btn-excluir").click(function(){
				alert("clicou em excluir.");
				//$(this).parents('form:first').attr("action", "");
				$(this).parents('form:first').submit();
			});

			$(".btn-aplicar").click(function(){
				$(this).parents('form:first').attr("action", "aplicar_questionario.php");
				$(this).parents('form:first').submit();
			});

            //Muda o Link Ativo no Menu lateral
            $("#meus_questionarios").addClass("active");
            $("#opcoes_questionario").collapse("show");
            $("#teste").addClass("active");  
            $("#home").removeClass("active");

			function apresentaTodos(){
				$.ajax({
					type: "POST",
					url: "scripts/todosQuestionarios.php",
					dataType: "json",
                    success: function(retorno){
						if(retorno == 0){
							$("#panel_sem_questionarios").show();
						}else{
							$("#panel_sem_questionarios").hide();
							
							var linhas = "";
							var contador = 1;
							retorno.forEach(function(item){
								alert(contador);
								linhas += "<div class='panel-heading container-fluid'>",
									linhas += "<a class='panel-title' data-toggle='collapse' data-parent='#panel_questionarios' href='#colapse_0"+contador+"'>";
										linhas += "<span class='span_link_panel'>";
										linhas += "<div class='row'>";
											linhas += "<div class='heading_questionarios col-md-10 col-sm-10 col-xs-8'>";
												linhas += "<span>"+item[contador - 1]["quest_nome"]+"</span>";
								
							});

							$("#panel_questionario").html(linhas);
						}
					}
				});
			}         

			$(document).ready(function(){
				apresentaTodos();
			});

			$("#lbl_todos").click(function(){
				apresentaTodos();
			});

			         
        </script>        
    </body>
</html>    