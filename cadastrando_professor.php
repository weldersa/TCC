<?php
//Inicia a sessão
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header('location: cadastro_professor.php');
}

include "classes/conexao.class.php";
include "classes/professor.class.php";

$nome = $_POST['txt_professor_nome'];
$sobrenome = $_POST['txt_professor_sobrenome'];
$email = $_POST['txt_email'];
$senha1 = $_POST['txt_senha1'];
$senha2 = $_POST['txt_senha2'];
$cpf = $_POST['txt_professor_cpf'];
$rg = $_POST['txt_professor_rg'];

$instituicao = $_SESSION['inst_codigo'];

$conexao = new Conexao();

$query = ("SELECT user_email FROM usuarios WHERE user_email = '{$email}';");
$resultado = $conexao->executaComando($query) or die("Erro ao checar email.");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){           //Se não recebeu dados, não insere no banco    
        if(trim($nome) == "" || trim($sobrenome) == "" || trim($email) == "" || trim($senha1) == "" || trim($senha2) == "" || trim($cpf) == "" || trim($rg) == "" || trim($ra) == ""){
            echo "Nenhum dado recebido!";
        }else{
            if(mysqli_num_rows($resultado) == 0){
                if($senha1 == $senha2){
                    if(strlen($senha1) >= 8){
                        $professor = new Professor($email, $senha1, $nome, $sobrenome, $rg, $cpf, $instituicao);
                            if($professor->insertProfessor()){
                                $_SESSION['msg_cadastro'] = "Professor Cadastrado com Sucesso!";
                            }else{
                                $_SESSION['msg_cadastro'] = "Ocorreu um erro ao cadastrar o professor!";
                            }
                    }else{
                        $_SESSION['msg_cadastro'] = "A senha deve ser maior que 8 caracteres!";
                    }
                }else{
                    $_SESSION['msg_cadastro'] = "As senhas não coincidem!";
                }
            }else{
                $_SESSION['msg_cadastro'] = "Email do professor em uso, tente novamente!";
            }
        }
    }
    unset($_POST);

?>

<html lang="pt-BR">
    <head>
        <title>Professor Cadastrado</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página --> 
			<div class="container-fluid" id="opcao_pergunta">
                <div class="row">
                    <div class="col-md-3">

                        <?php

                        if($_SESSION['msg_cadastro'] == "Professor Cadastrado com Sucesso!"){
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
                    if($_SESSION['msg_cadastro'] !=  "Professor Cadastrado com Sucesso!"){
                        echo "<input type='button' id='btn_voltar' class='btn btn-default' value='Voltar'/>";
                    }
                    ?>

                    <input type="button" id="btn_ver_professores" class="btn btn-primary" value= "Ver Professores"/>
                    <input type="button" id="btn_novo_questionario" class="btn btn-success" value= "Cadastrar Professor"/>
                </div>
            </div>
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#btn_voltar").click(function(){
                javascript:window.history.go(-1)
            });
            $("#btn_ver_professores").click(function(){
                window.location.href = "professores.php";
            });

            $("#btn_novo_questionario").click(function(){
                window.location.href = "criar_questionario.php";
            });

            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");                   
        </script>        
    </body>
</html