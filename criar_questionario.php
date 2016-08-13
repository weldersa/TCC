<!--
DATA: 14/05/16    
ARQUIVO: criar_questionario.php
DESCRIÇÃO: Página de criação de Questionários
-->   
<!DOCTYPE html>
<?php
    //Imports
    require_once "classes/questionario.class.php";
    
    //Coleta data para colocar no placeholder para navegadores sem campo "date-time-local"
    date_default_timezone_set("America/Sao_Paulo");
    $date = date('d/m/Y');
    $time = date('H:i');

	// Inicia a Sessão
	session_start();
    
    if($_SESSION["user_tipo"] != "P"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }
    
    if( $_SERVER['REQUEST_METHOD'] == 'POST'){

                $questionario = new Questionario();
                $questionario->setProfessor($_SESSION["user_email"]);                
                $questionario->setNome($_POST['txt_quest_nome']);
                $questionario->setMateria($_POST['txt_quest_materia']);
                $questionario->setTempo($_POST["txt_tempo_resposta"]);
                $questionario->setVisualizaResposta();
                $_SESSION["questionario"] = serialize($questionario);
                $_SESSION["numPerguntas"] = 0;
                $perguntas = array();
                $perguntas_alternativas = array();
                $_SESSION["perguntas_alternativas"] = serialize($perguntas_alternativas);
                $_SESSION["perguntas"] = serialize($perguntas);
                header("location: sumario_questionario.php");
    
    }
?>
  
<html lang="pt-BR">
    <head>
        <title>Criar Questionário</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>
        <?PHP include 'menu.php';?>
        <div class="container" id="criando_questionario">
            <form class="form" id="quest_parte_1" method="POST" action="#" target="_self">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Criar um Questionário:</h3>
                            Por favor Preencha as informações abaixo para iniciar a criação do questionário.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">               
                            <label for="txt_quest_nome">Nome do Questionário</label>
                            <input type="text" class="form-control" id="txt_quest_nome" name="txt_quest_nome" placeholder="Ex: Questionário de Matemática" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="txt_quest_materia">Matéria</label>
                            <input type="text" class="form-control typeahead" id="txt_quest_materia" name="txt_quest_materia" placeholder="Ex: Matemática" required>
                        </div>
                        <div class="col-md-6">
                            <label for="txt_tempo_resposta">Tempo para responder</label>
                            <div class="input-group">
                                <div class="input-group-addon"><input type="checkbox" id="chk_tempo_resposta"></div>
                                <input type="number" class="form-control" id="txt_tempo_resposta" name="txt_tempo_resposta" placeholder="Tempo" required disabled>
                                <div class="input-group-addon">Minutos</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <div class="pull-right">
                                <button type="submit" id="btn_continuar" class="btn btn-primary">Continuar</button>
                            </div>                                    
                        </div>                            
                    </div>                        
                </div>        
            </form>                       
        </div>   
    </body>      
    
    <!-- Importa Date e Time Picker -->
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">
    <script type="text/javascript" src="js/moment.js"></script>
    <script type="text/javascript" src="js/pt-br.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    
    <script> 
    
            //Muda o Link Ativo no Menu lateral
            $("#criar_questionario").addClass("active");
            $("#opcoes_questionario").collapse("show");
            $("#teste").addClass("active");  
            $("#home").removeClass("active");
            
            //Ativa e Desativa Campo de Tempo de Resposta
            $("#chk_tempo_resposta").change(function(){              
                if($(this).is(':checked')){
                    $("#txt_tempo_resposta").prop("disabled", false);
                }else{
                    $("#txt_tempo_resposta").prop("disabled", true);
                }
            }); 
    </script>         
</html>    