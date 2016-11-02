<?php
//Inicia a sessão
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header('location: cadastro_turma.php');
}

include "classes/conexao.class.php";

$nome = $_POST['txt_turma_nome'];
$instituicao = $_SESSION['inst_codigo'];

$conexao = new Conexao();
$resultado = $conexao->executaComando("SELECT turma_nome FROM turmas WHERE turma_nome = '$nome' AND turma_instituicao = $instituicao");


    if($_SERVER['REQUEST_METHOD'] == 'POST'){           //Se não recebeu dados, não insere no banco    
        if(trim($nome) == ""){
            echo "Nenhum dado recebido!";
        }else{
            if(mysqli_num_rows($resultado) == 0){
				if($conexao->executaComando("INSERT INTO turmas (turma_nome, turma_instituicao) VALUES('$nome', $instituicao)")){
					$_SESSION['msg_cadastro'] = "Turma cadastrada com sucesso!";
				}else{
						$_SESSION['msg_cadastro'] = "Erro ao cadastrada turma!";
				}
            }else{
                $_SESSION['msg_cadastro'] = "Já existe uma turma cadastrada com esse nome!";
            }
        }
    }
    unset($_POST);

?>

<html lang="pt-BR">
    <head>
        <title>Cadastrando Turma</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página --> 
			<div class="container-fluid" id="opcao_pergunta">
                <div class="row">
                    <div class="col-md-3">

                        <?php

                        if($_SESSION['msg_cadastro'] == "Turma cadastrada com sucesso!"){
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
                    if($_SESSION['msg_cadastro'] !=  "Turma cadastrada com sucesso!"){
                        echo "<input type='button' id='btn_voltar' class='btn btn-default' value='Voltar'/>";
                    }
                    ?>

                    <input type="button" id="btn_ver_turmas" class="btn btn-primary" value= "Ver Turmas"/>
                    <input type="button" id="btn_cadastrar_turma" class="btn btn-success" value= "Cadastrar Turma"/>
                </div>
            </div>
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#btn_voltar").click(function(){
                javascript:window.history.go(-1)
            });
            $("#btn_ver_turmas").click(function(){
                window.location.href = "turmas.php";
            });

            $("#btn_cadastrar_turma").click(function(){
                window.location.href = "cadastro_turmas.php";
            });

            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");                   
        </script>        
    </body>
</html