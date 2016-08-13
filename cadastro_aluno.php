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
        <title>Cadastro de Alunos</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
          	<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						 <h3>Cadastrar Aluno</h3>
					</div>
				</div>				
				<div class="row">
					<div class="col-md-6">
						<label for="txt_aluno_nome">Nome:</label>
						<input type="text" class="form-control" id="txt_aluno_nome">
					</div>
					<div class="col-md-6">
						<label for="txt_aluno_sobrenome">Sobrenome:</label>
						<input type="text" class="form-control" id="txt_aluno_sobrenome">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="txt_aluno_nome">Turma:</label>
						<select class="form-control" id="slc_turma_aluno">
							<option>Selecione uma Turma</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="txt_aluno_email">Email:</label>
						<input type="text" class="form-control" id="txt_aluno_email">
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label for="txt_aluno_senha">Senha:</label>
						<input type="text" class="form-control" id="txt_aluno_senha">
					</div>
					<div class="col-md-6">
						<label for="txt_aluno_confirma-senha">Confirme a Senha:</label>
						<input type="text" class="form-control" id="txt_aluno_confirma-senha">
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="txt_aluno_cpf">CPF:</label>
						<input type="text" class="form-control" id="txt_aluno_cpf">
					</div>
					<div class="col-md-4">
						<label for="txt_aluno_rg">RG:</label>
						<input type="text" class="form-control" id="txt_aluno_rg">
					</div>
					<div class="col-md-4">
						<label for="txt_aluno_ra">RA:</label>
						<input type="text" class="form-control" id="txt_aluno_ra">
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