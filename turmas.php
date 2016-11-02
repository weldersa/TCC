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
    
$conexao = new Conexao();

$resultado = $conexao->executaComando("SELECT * FROM turmas WHERE turma_instituicao=$_SESSION[inst_codigo];");

//$resultado = $conexao->executaComando("SELECT usuarios.user_nome, usuarios.user_email, alunos.aluno_sobrenome, aluno_turma.aluno_email, aluno_turma.turma_codigo, turmas.turma_nome FROM usuarios INNER JOIN alunos ON alunos.aluno_email=usuarios.user_email INNER JOIN aluno_turma ON aluno_turma.aluno_email=usuarios.user_email INNER JOIN turmas ON turmas.turma_codigo=aluno_turma.turma_codigo");

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
        ?>
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <br>
                        <h4>Turmas:</h4>
                    </div>
                </div> <!-- Row End -->
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="panel-group" id="panel_perguntas">
                            <?PHP  
                                if(mysqli_num_rows($resultado) == 0){
                                    echo '
                                        <div class="panel panel-default">
                                            <div class="panel-heading div_panel">
                                                <span> Nenhuma turma encontrada </span>
                                            </div>
                                        </div>
                                    ';
                                }else{
                                    while($linha = mysqli_fetch_array($resultado)){
										$resultado2 = $conexao->executaComando("SELECT count(*) AS qtd_alunos from aluno_turma where turma_codigo = $linha[turma_codigo]");
										$linha2 = mysqli_fetch_array($resultado2);
										$qtd_alunos = $linha2['qtd_alunos'];
										$resultado3 = $conexao->executaComando("SELECT usuarios.user_nome, alunos.aluno_sobrenome FROM usuarios INNER JOIN alunos ON usuarios.user_email=alunos.aluno_email INNER JOIN aluno_turma ON aluno_turma.aluno_email=usuarios.user_email WHERE aluno_turma.turma_codigo = '$linha[turma_codigo]'");

                                        echo "
                                            <div class='panel panel-default'>
                                                <div class='panel-heading container-fluid'>
                                                    <a class='panel-title' data-toggle='collapse' data-parent='#panel_perguntas' href='#colapse_0".$linha['turma_codigo']."'>
                                                    <span class='span_link_panel'>
                                                        <div class='row'>
                                                            <div class='div_panel col-md-10 col-sm-10 col-xs-8'>               
                                                                <span><b>".$linha['turma_nome']." <br></span> </b>Alunos: ".$qtd_alunos."<br>
                                                            </div>
                                                            <div id='div_panel_detalhes' class='div_panel col-md-2 col-sm-2 col-xs-4'>
                                                                <span>Detalhes</span>
                                                            </div>
                                                        </div>
                                                    </span>
                                                    </a>
                                                </div>
                                                <div id='colapse_0".$linha['turma_codigo']."' class='panel-collapse collapse'>
                                                    <div class='panel-body'>";
                                                        
                                                        if($qtd_alunos == 0){
                                                            echo "Essa turma não tem alunos cadastrados";
                                                        }else{
															while($linha3 = mysqli_fetch_array($resultado3)){
																echo "$linha3[user_nome] $linha3[aluno_sobrenome]";
																echo "<br>";  
															}
                                                        }
                                        echo"                

													<div class='botoes_questionarios pull-right'>
														<button type='button' style='margin-right: 5px' class='btn btn-danger btn-excluir'>Excluir Turma</button>
														<button type='button' style='margin-right: 5px' class='btn btn-primary btn-editar'>Editar Turma</button>
														<button type='button' style='margin-right: 5px' class='btn btn-success btn-aplicar'>Adicionar Alunos</button>
													</div>
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
                    <div class="col-md-12">
                        <input type="button" id="btn_cadastrar_turma" class="btn btn-success pull-right" value="Cadastrar Turma">
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

                $("#btn_cadastrar_turma").click(function(){
                    window.location.href = "cadastro_turma.php";
                })
                
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