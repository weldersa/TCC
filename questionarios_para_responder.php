<!--
DATA: 03/05/16    
ARQUIVO: questionarios_para_responder.php
DESCRIÇÃO: Pagina que lista questionários disponíveis para o aluno responder.
-->

<!DOCTYPE html>
<?php
	//Imports
    require_once "classes/questionario.class.php";		
	require_once "classes/conexao.class.php";

	// Inicia a Sessão
	session_start();
    
	if($_SESSION["user_tipo"] != "A"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }
?>

<html lang="pt-BR">
    <head>
        <title>Questionários para Responder</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>

        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="container-fluid">
				<div class="row">
                    <div class="col-md-12 col-xs-12">
						<h3>Questionários para responder:</h3>
						<br>
                    </div>
                </div> <!-- Row End -->
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<center>
                        <div id="rb_tipo_pergunta" class="btn-group" data-toggle="buttons">
							<label id="lbl_responder" class="btn btn-primary active">
								<input type="radio" name="questionarios_responder" value="todos" id="cbx_todosQuests" autocomplete="off" checked="checked">Disponíveis
							</label>
							<label id="lbl_respondidos" class="btn btn-primary">
								<input type="radio" name="questionarios_respondidos" value="aplicados" id="cbx_questsAplicados" autocomplete="off">Respondidos
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
								
							</div>
						</div>
					</div>
				</div>
			</div>                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            //Muda o Link Ativo no Menu lateral
            $("#responderQuestionarios").addClass("active");
            $("#home").removeClass("active");

			function apresentaQuestionarios(url){
				var linhas = "";
				$.ajax({
					type: "POST",
					url: "scripts/" + url,
					dataType: "json",
                    success: function(retorno){
						if(retorno == 0){
							linhas += '<div class="panel-heading div_panel">';
							
								switch(url){
									case "questsParaResponder.php":
										linhas += "<span id='span_sem_quests'>Não há questionários disponíveis para responder</span>";
										break;
									case "questsRespondidos.php":
										linhas += "<span id='span_sem_quests'>Ainda não respondeu nenhum questionário</span>";
										break;
								}

							linhas += '</div>';	

							$("#panel_questionario").empty();
							$("#panel_questionario").html(linhas);

						}else{							
							var contador = 1;
							retorno.forEach(function(item){
								//Cabeçalho do Panel
								linhas += "<div class='panel-heading container-fluid'>",
									linhas += "<a class='panel-title' data-toggle='collapse' data-parent='#panel_questionarios' href='#colapse_0"+contador+"'>";
										linhas += "<span class='span_link_panel'>";
											linhas += "<div class='row'>";
												linhas += "<div class='heading_questionarios col-md-10 col-sm-10 col-xs-8'>";
													linhas += "<span>"+item["quest_nome"]+"</span>";
												linhas += "</div>";
												linhas += "<div id='div_panel_detalhes' class='div_panel col-md-2 col-sm-2 col-xs-4'>";
													linhas += "<span>Detalhes</span>";
												linhas += "</div>";
											linhas += "</div>";
										linhas += "</span>";
									linhas += "</a>";
								linhas += "</div>";

								//Corpo do Panel
								linhas += "<div id='colapse_0" + contador + "' class='panel-collapse collapse'>";
									linhas += "<div class='panel-body'>";
										linhas += "<form method='POST' target='_self' action='#'>";

											switch(url){
												case "questsParaResponder.php":
													linhas += "<input id='quest_nome' name='quest_nome' type='hidden' value='"+ item["quest_nome"] +"' readonly/>";
													linhas += "<input id='quest_turma' name='quest_turma' type='hidden' value='"+ item["turma"] +"' readonly/>";
													linhas += "<input id='quest_tempo' name='quest_tempo' type='hidden' value='"+ item["quest_tempo"] +"' readonly/>";
													linhas += "<input id='cod_questionario' name='quest_codigo' type='hidden' value='"+ item["quest_codigo"] +"' readonly/> ";
													linhas += "<b>Matéria:</b> " + item["quest_materia"] + "<br>";
													linhas += "<b>Número de Perguntas:</b> " + item["quest_numPerguntas"] + "<br>";

													if(item["quest_tempo"] == 0){	
														linhas += "<b>Tempo para Resposta:</b> Sem limite de tempo<br>";
													}else{
														linhas += '<b>Tempo para Resposta:</b> ' + item["quest_tempo"] + ' Minutos<br>';
													}
											
													linhas += "<b>Aplicado em:</b> " + item["data_inicio"] + "<br>";
													linhas += "<b>Data limite para resposta:</b> " + item["data_fim"] + "<br>";
													linhas += "<b>Criado por:</b> " + item["prof_nome"] + " " + item["prof_sobrenome"] + "<br>";
													linhas += "<div class='botoes_questionarios pull-right'>";
													linhas += "<button type='button' style='margin-right: 5px' class='btn btn-success btn-responder'>Responder questionário</button>";
													linhas += "</div>";
													break;

												case "questsRespondidos.php":
													linhas += "<input id='quest_nome' name='quest_nome' type='hidden' value='"+ item["quest_nome"] +"' readonly/>";
													linhas += "<input id='quest_turma' name='quest_turma' type='hidden' value='"+ item["turma_codigo"] +"' readonly/>";
													linhas += "<input id='quest_tempo' name='quest_tempo' type='hidden' value='"+ item["quest_tempo"] +"' readonly/>";
													linhas += "<input id='cod_questionario' name='quest_codigo' type='hidden' value='"+ item["quest_codigo"] +"' readonly/> ";
													linhas += "<input id='data_resposta' name='data_resposta' type='hidden' value='"+ item["data_resposta_completa"] +"' readonly/> ";
													linhas += "<b>Matéria:</b> " + item["quest_materia"] + "<br>";
													linhas += "<b>Número de Perguntas:</b> " + item["quest_numPerguntas"] + "<br>";
													linhas += "<b>Criado por:</b> " + item["prof_nome"] + " " + item["prof_sobrenome"] + "<br>";
													linhas += "<b>Turma:</b> " + item["turma"] + "<br><br>";
													linhas += "<b>Repondido em:</b> " + item["data_resposta"] + "<br>";

													linhas += "<div class='botoes_questionarios pull-right'>";
														linhas += "<button type='button' style='margin-right: 5px' class='btn btn-success btn-verRespostas'>Visualizar Respostas</button>";
													linhas += "</div>";
													break;
											}
										linhas += "</form>";
									linhas += "</div>";
								linhas += "</div>";


								contador++;
							});
							$("#panel_questionario").empty();
							$("#panel_questionario").html(linhas);								
						}
					}
				});
			}         

			$(document).ready(function(){
				apresentaQuestionarios("questsParaResponder.php");
			});

			$("#lbl_responder").click(function(){
				apresentaQuestionarios("questsParaResponder.php");
			});

			$("#lbl_respondidos").click(function(){
				apresentaQuestionarios("questsRespondidos.php");
			});

			$("#panel_questionario").delegate('.btn-responder', 'click', function(){
				$(this).parents('form:first').attr("action", "respondendo.php");
				$(this).parents('form:first').submit();
			});

			$("#panel_questionario").delegate('.btn-verRespostas', 'click', function(){
				$(this).parents('form:first').attr("action", "apresenta_respostas.php");
				$(this).parents('form:first').submit();
			});
        </script>        
    </body>
</html>    