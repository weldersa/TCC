<!--
DATA: 25/05/16    
ARQUIVO: sumario_questionario.php
DESCRIÇÃO: Página de sumario de Questionários
-->   

<?PHP
    //Imports
	include "classes/conexao.class.php";
    //Inicia a sessão
    session_start();

	if($_SESSION["user_tipo"] != "I"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }
    


?>

<html>
    <head>
        <?PHP include 'imports.html'; ?>
        <title>Turmas</title>
    </head>
    <body>
        <?PHP 
            include 'menu.php';
            //Atribui o número de perguntas já criadas para que possa ser usado no javascript
            echo '<input type="hidden" name="txtNumPergunta" id="txtNumPergunta" value="'.$_SESSION['numPerguntas'].'">'; 
        ?>
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <?PHP
                            echo "<h3>".$questionario->getNome()."</h3>";
                            /*
                            echo "<br><h4> Professor: ".$questionario->getProfessor();
                            echo "<br>Matéria: ".$questionario->getMateria();
                            echo "<br>Tempo para Responder: ".$questionario->getTempo();
                            echo "<br>Data de Início: ".$questionario->getDataInicio();
                            echo "<br>Data de Término: ".$questionario->getDataFim()."</h4>";
                            */
                        ?>
                    </div>
                </div> <!-- Row End -->
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <br>
                        <h4>Perguntas:</h4>
                        
                    </div>
                </div> <!-- Row End -->
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="panel-group" id="panel_perguntas">
                            <?PHP  
                                if($_SESSION["numPerguntas"] == 0){
                                    echo '
                                        <div class="panel panel-default">
                                            <div class="panel-heading div_panel">
                                                <span> Nenhuma turma encontrada </span>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    for ($i = 1; $i <= $_SESSION["numPerguntas"]; $i++){
                                        echo "
                                            <div class='panel panel-default'>
                                                <div class='panel-heading container-fluid'>
                                                    <a class='panel-title' data-toggle='collapse' data-parent='#panel_perguntas' href='#colapse_0".$i."'>
                                                    <span class='span_link_panel'>
                                                        <div class='row'>
                                                            <div class='div_panel col-md-10 col-sm-10 col-xs-8'>               
                                                                <span><b>Pergunta ".$perguntas[$i]->getNumPergunta().": <br></span> </b>".$perguntas[$i]->getEnunciado()."
                                                            </div>
                                                            <div id='div_panel_detalhes' class='div_panel col-md-2 col-sm-2 col-xs-4'>
                                                                <span>Detalhes</span>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    </a>
                                                </div>
                                                <div id='colapse_0".$i."' class='panel-collapse collapse'>
                                                    <div class='panel-body'>
                                                        Número da Pergunta: ".$perguntas[$i]->getNumPergunta()."<br>
                                                        Tipo da Pergunta: ".$perguntas[$i]->getTipo()."<br>";
                                                        
                                                        if($perguntas[$i]->getNumAlternativas() == ""){
                                                            echo "Número de Alternativas: 0 - Pergunta Dissertativa<br>";
                                                        }else{
                                                            echo "Número de Alternativas: ".$perguntas[$i]->getNumAlternativas()."<br><br>";
                                                            
                                                            for($j = 1; $j <= $perguntas[$i]->getNumAlternativas(); $j++){
                                                                $alternativaAtual = $perguntas_alternativas[$i]->getAlternativa($j);
                                                                if($alternativaAtual["correta"]){
                                                                    $correta = "Correta";
                                                                }else{
                                                                    $correta = "Errada";
                                                                }
                                                                
                                                                echo "Alternativa 0".$alternativaAtual["ordem"].": ".$alternativaAtual["texto"]." (".$correta.")<br>" ;
                                                            }   
                                                            
                                                            echo "<br>";  
                                                        }  
                                                            
                                                        if($perguntas[$i]->getImagem() == ""){
                                                            echo "Caminho da Imagem: Sem Imagem<br>";
                                                        }else{
                                                            
                                                        }                
                                                        
                                                        if($perguntas[$i]->getPeso() == ""){
                                                            echo "Peso da Pergunta: Sem peso definido<br>";
                                                        } else{
                                                            echo "Peso da Pergunta: ".$perguntas[$i]->getPeso()."<br>";
                                                        }
                                                        
                                                        echo "Tags da Pergunta: ";
                                                        print_r(array_values($perguntas[$i]->getTags()));               
                                                        
                                        echo"                
                                                    </div>
                                                </div>
                                            </div>
                                        "; 
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div> <!-- Row End -->                        
                <div class="row">
                    <div class="col-md-12 col-xs-12">                      
                        <div id="div_botoes_sumario">                                 
                            <button class="btn btn-primary" id="btn_addPergunta">Adicionar Pergunta</button>                           
                            <button type="submit" class="btn btn-success" id="btn_finalizaQuest">Continuar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $("#btn_voltar").click(function(){
                    window.location.href = "criar_questionario.php";
                });

                $("#btn_addPergunta").click(function(){
                    window.location.href = "criar_pergunta.php";
                });
                
                $("#btn_finalizaQuest").click(function(){
                    if($("#txtNumPergunta").val() < 2){
                        alert("O número mínimo de perguntas para criar o questionário é '2'.");
                    }else{
                        window.location.href = "peso_perguntas.php";
                    }
                });
            });
        </script>
    </body>
</html>