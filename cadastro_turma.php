<!--
DATA: 03/05/16    
ARQUIVO: home.php
DESCRIÇÃO: Página de início, primeira página após o login
-->

<!DOCTYPE html>
<?php
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
        <title>Cadastro de Turmas</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
          	<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						 <h3>Cadastrar uma nova turma</h3>
					</div>
				</div>				
				<div class="row">
					<div class="col-md-12">
						<label for="txt_aluno_nome">Nome da Turma:</label>
						<input type="text" class="form-control" id="txt_aluno_nome">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<br><br>
						<input type="submit" value="Cadastrar" class="btn btn-success pull-right">
					</div>
				</div>
			</div> 
                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");                   
        </script>        
    </body>
</html>    