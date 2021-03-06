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
								
							</div>
						</div>
					</div>
				</div>
			</div>                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            //Muda o Link Ativo no Menu lateral
            $("#meus_questionarios").addClass("active");
            $("#opcoes_questionario").collapse("show");
            $("#teste").addClass("active");  
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
									case "todosQuestionarios.php":
										linhas += "<span id='span_sem_quests'>Não há questionários criados</span>";
										break;
									case "questionariosAplicados.php":
										linhas += "<span id='span_sem_quests'>Não há questionários aplicados</span>";
										break;
									case "questionariosNaoAplicados.php":
										linhas += "<span id='span_sem_quests'>Não existem questionários criados ou todos estão aplicados</span>";
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
											linhas += "<input id='quest_nome' name='quest_nome' type='hidden' value='"+ item["quest_nome"] +"' readonly/>"
											linhas += "<b>Código do Questionário:</b> <input id='cod_questionario' name='cod_questionario' type='text' value='"+ item["quest_codigo"] +"' readonly/><br>";
											linhas += "<b>Matéria:</b> " + item["quest_materia"] + "<br>";
											linhas += "<b>Número de Perguntas:</b> " + item["quest_numPerguntas"] + "<br>";

											if(item["quest_tempo"] == 0){	
												linhas += "<b>Tempo para Resposta:</b> Sem limite de tempo<br><br>";
											}else{
												linhas += '<b>Tempo para Resposta:</b> "' + item["quest_tempo"] + '" Minutos.<br><br>';
											}

											linhas += "<div class='botoes_questionarios pull-right'>";
												linhas += "<button type='button' style='margin-right: 5px' class='btn btn-danger btn-excluir'>Excluir</button>";
												linhas += "<button type='button' style='margin-right: 5px' class='btn btn-primary btn-editar'>Editar</button>";
												linhas += "<button type='button' style='margin-right: 5px' class='btn btn-success btn-aplicar'>Aplicar</button>";
											linhas += "</div>";
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
				apresentaQuestionarios("todosQuestionarios.php");
			});

			$("#lbl_todos").click(function(){
				apresentaQuestionarios("todosQuestionarios.php");
			});

			$("#lbl_aplicados").click(function(){
				apresentaQuestionarios("questionariosAplicados.php");
			});

			$("#lbl_naoAplicados").click(function(){
				apresentaQuestionarios("questionariosNaoAplicados.php");
			});

			$("#panel_questionario").delegate('.btn-excluir', 'click', function(){
				alert("clicou em excluir.");
				//$(this).parents('form:first').attr("action", "");
				$(this).parents('form:first').submit();
			});

			$("#panel_questionario").delegate('.btn-aplicar', 'click', function(){
				$(this).parents('form:first').attr("action", "aplicar_questionario.php");
				$(this).parents('form:first').submit();
			});
        </script>        
    </body>
</html>    