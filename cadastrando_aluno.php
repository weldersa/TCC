<?php
//Inicia a sessão
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header('location: cadastro_aluno.php');
}

include "classes/conexao.class.php";
include "classes/aluno.class.php";

$nome = $_POST['txt_aluno_nome'];
$sobrenome = $_POST['txt_aluno_sobrenome'];
$turma = $_POST['slc_turma_aluno'];
$email = $_POST['txt_email'];
$senha1 = $_POST['txt_senha1'];
$senha2 = $_POST['txt_senha2'];
$cpf = $_POST['txt_aluno_cpf'];
$rg = $_POST['txt_aluno_rg'];
$ra = $_POST['txt_aluno_ra'];

$instituicao = $_SESSION['inst_codigo'];

$conexao = new Conexao();

$query = ("SELECT user_email FROM usuarios WHERE user_email = '{$email}';");
$resultado = $conexao->executaComando($query) or die("Erro ao checar email.");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){           //Se não recebeu dados, não insere no banco    
        if(trim($nome) == "" || trim($sobrenome) == "" || trim($turma) == "" || trim($email) == "" || trim($senha1) == "" || trim($senha2) == "" || trim($cpf) == "" || trim($rg) == "" || trim($ra) == ""){
            echo "Nenhum dado recebido!";
        }else{
            if(mysqli_num_rows($resultado) == 0){
                if($senha1 == $senha2){
                    if(strlen($senha1) >= 8){
                        $aluno = new Aluno($email, $senha1, $nome, $sobrenome, $ra, $rg, $cpf, $instituicao);
                            if($aluno->insertAluno()){
                                $_SESSION['msg_cadastro'] = "Aluno Cadastrado com Sucesso!";
                            }else{
                                $_SESSION['msg_cadastro'] = "Ocorreu um erro ao cadastrar o aluno!";
                            }
                    }else{
                        $_SESSION['msg_cadastro'] = "A senha deve ser maior que 8 caracteres!";
                    }
                }else{
                    $_SESSION['msg_cadastro'] = "As senhas não coincidem!";
                }
            }else{
                $_SESSION['msg_cadastro'] = "Email do aluno em uso, tente novamente!";
            }
        }
    }
    unset($_POST);

?>

<html lang="pt-BR">
    <head>
        <title>Aluno Cadastrado</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página --> 
			<div class="container-fluid" id="opcao_pergunta">
                <div class="row">
                    <div class="col-md-3">

                        <?php

                        if($_SESSION['msg_cadastro'] == "Aluno Cadastrado com Sucesso!"){
                            echo "<img src='resources/images/sucesso.png'>";
                        }else{
                            echo "<img src='resources/images/erro.png'>";
                        }

                        ?>

                    </div>
                    <div class="col-md-9">
                        <br><br>
                        <center><b> <?php echo $_SESSION['msg_cadastro']; ?> </b></center>
                    </div>
                </div>
			</div>
            <div class="container-fluid">
                <div class="pull-right">
                    <br>

                    <?php
                    if($_SESSION['msg_cadastro'] !=  "Aluno Cadastrado com Sucesso!"){
                        echo "<input type='button' id='btn_voltar' class='btn btn-default' value='Voltar'/>";
                    }
                    ?>

                    <input type="button" id="btn_meus_questionarios" class="btn btn-primary" value= "Ver Alunos"/>
                    <input type="button" id="btn_novo_questionario" class="btn btn-success" value= "Cadastrar Aluno"/>
                </div>
            </div>
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#btn_voltar").click(function(){
                javascript:window.history.go(-1)
            });
            $("#btn_meus_questionarios").click(function(){
                window.location.href = "meus_questionarios.php";
            });

            $("#btn_novo_questionario").click(function(){
                window.location.href = "criar_questionario.php";
            });

            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");                   
        </script>        
    </body>
</html