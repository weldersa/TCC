<!--
DATA: 03/05/16    
ARQUIVO: home.php
DESCRIÇÃO: Página de início, primeira página após o login
-->

<!DOCTYPE html>
<?php
	// Inicia a Sessão
	session_start();
    
    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }
?>

<html lang="pt-BR">
    <head>
        <title>Pagina Principal</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
        <h2>Bem vindo ao Frage!</h2>
        Use o menu lateral para navegar entre as telas do sistema
            <br><br>
            <?php
                switch($_SESSION["user_tipo"]){
                    case "A":
                        echo "<div class='row'>
                                <div class='col-md-6'>
                                    <div class='painel-red painel-info-red'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-time' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'>1</div>
                                                    <div>Questionários Pendentes</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class='col-md-6'>
                                    <div class='painel-green painel-info-green'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'>1</div>
                                                    <div>Questionários Respondidos</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div> <!-- Row End -->";
                        break;

                    case "P":
                            echo "<div class='row'>
                                <div class='col-md-6'>
                                    <div class='painel-blue painel-info-blue'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-book' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'><span id='quests_criados'>0</span></div>
                                                    <div>Questionários criados</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class='col-md-6'>
                                    <div class='painel-green painel-info-green'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'><span id='quests_aplicados'>0</div>
                                                    <div>Questionários aplicados</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div> <!-- Row End -->
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='painel-red painel-info-red'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-file' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'><span id='quests_nao_aplicados'>0</span></div>
                                                    <div>Questionários não aplicados</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>";
                        break;

                    case "I":
                        echo "<div class='row'> 
                                <div class='col-md-6'>
                                    <div class='painel-blue painel-info-blue'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-blackboard' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'><span id='num_turmas'>0</span></div>
                                                    <div>Turmas Cadastradas</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <div class='col-md-6'>
                                    <div class='painel-green painel-info-green'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-pencil gliph_aluno' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'><span id='num_alunos'>0</span></div>
                                                    <div>Alunos Cadastrados</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                            </div> <!-- Row End -->
                            <div class='row'>
                                <div class='col-md-12'>
                                    <div class='painel-purple painel-info-purple'>
                                        <div class='painel-heading'>
                                            <div class='row'>
                                                <div class='col-xs-3'>
                                                    <span class='glyphicon glyphicon-briefcase' aria-hidden='true'></span>
                                                </div>                                
                                                <div class='col-xs-9 text-right'>
                                                    <div class='huge'><span id='num_professores'>0</span></div>
                                                    <div>Professores Cadastrados</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            ";
                        break;
                }
            ?>    
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");

            $(document).ready(function(){
                consultaTurma();
                consultaAlunos();
                consultaProfessores();
                questsCriados();
                questsAplicados();
                questsNaoAplicados();
            }); 

            function consultaAjax(operacao, campo){
                var op = operacao;
                var dataString = "operacao="+op;
                
                $.ajax({
                    type: "POST",
                    url: "scripts/counter.php",
                    data: dataString,
                    cache: false,
                    dataType: "json",
                    success: function(data){
                        $(campo).html(data);
                    }
                });
            }  

            //Consulta o número de turmas cadastradas pela instituição
            function consultaTurma(){
                consultaAjax("contaTurmas", "#num_turmas");
            }          
            
            //Consulta o número de alunos cadastradas pela instituição
            function consultaAlunos(){
                consultaAjax("contaAlunos", "#num_alunos");
            }

            //Consulta o número de professores cadastrados instituição
            function consultaProfessores(){
                consultaAjax("contaProfessor", "#num_professores");
            }

            function questsCriados(){
                consultaAjax("quests_criados", "#quests_criados");
            }

            function questsAplicados(){
                consultaAjax("quests_aplicados", "#quests_aplicados");
            }

            function questsNaoAplicados(){
                consultaAjax("quests_nao_aplicados", "#quests_nao_aplicados");
            }
        </script>        
    </body>
</html>    