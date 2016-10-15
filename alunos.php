<!--
DATA: 15/10/16    
ARQUIVO: alunos.php
DESCRIÇÃO: Página de início, primeira página após o login
-->

<!DOCTYPE html>
<?php
include 'classes/conexao.class.php';
	// Inicia a Sessão
	session_start();

	if($_SESSION["user_tipo"] != "I"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }
?>

<html lang="pt-BR">
    <head>
        <title>Alunos</title>
        <?PHP include 'imports.html'; ?>
		<link rel="stylesheet" href="css/cadastro_aluno.css">
		<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="row">
                <div class="col-md-12">
                    <h3>Alunos</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="button" id="btn_cadastrar_aluno" class="btn btn-success" value="Cadastrar Aluno">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                <br>

                <div class="table_header">
                    <!-- As tags estão assim para evitar espaço entre as divs -->
                    <div id="header_enunciado">Enunciado</div
                    ><div id="header_tipo">Tipo</div
                    ><div id="header_peso">Peso</div>
                </div>

                <div class="table_body">
                    <div id="body_nenhuma">Nunhuma pergunta encontrada!</div>
                    <table id="tabela_perguntas">
                        <?php
                                
                                $query = ("SELECT usuarios.user_email, usuarios.user_nome, alunos.aluno_sobrenome, alunos.aluno_ra, alunos.aluno_rg, alunos.aluno_cpf FROM usuarios INNER JOIN alunos ON usuarios.user_email=alunos.aluno_email;");
                                $conexao = new Conexao();
                                $resultado = $conexao->executaComando($query) or die("Erro ao Buscar Alunos.");
                                if($resultado){
                                    while($linha = mysqli_fetch_array($resultado)){
                                        echo "<tr><td>$linha[user_nome] $linha[aluno_sobrenome]</td><td>$linha[user_email]</td><td>$linha[aluno_ra]</td><td>$linha[aluno_rg]</td><td>$linha[aluno_cpf]</td></tr>";
                                    }
                                }
                            ?>
                    </table>
                </div>

                    <table class="table">
                        <thread>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>RA</th>
                                <th>RG</th>
                                <th>CPF</th>
                            </tr>
                        </thread>
                        <tbody>
                            <?php
                                
                                $query = ("SELECT usuarios.user_email, usuarios.user_nome, alunos.aluno_sobrenome, alunos.aluno_ra, alunos.aluno_rg, alunos.aluno_cpf FROM usuarios INNER JOIN alunos ON usuarios.user_email=alunos.aluno_email;");
                                $conexao = new Conexao();
                                $resultado = $conexao->executaComando($query) or die("Erro ao Buscar Alunos.");
                                if($resultado){
                                    while($linha = mysqli_fetch_array($resultado)){
                                        echo "<tr><td>$linha[user_nome] $linha[aluno_sobrenome]</td><td>$linha[user_email]</td><td>$linha[aluno_ra]</td><td>$linha[aluno_rg]</td><td>$linha[aluno_cpf]</td></tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- Fim do Conteúdo da página -->
    </body>
</html