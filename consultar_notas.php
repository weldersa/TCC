<!--
DATA: 03/05/16    
ARQUIVO: home.php
DESCRIÇÃO: Página de início, primeira página após o login
-->

<!DOCTYPE html>
<?php
include "classes/conexao.class.php";
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
        <title>Consultar Notas</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
			<div class="row">
				<div class="col-md-12">
					<h3>Buscar notas por:</h3>
				</div>
			</div> <!-- Row End -->
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<center>
					<div id="rb_tipo_pergunta" class="btn-group" data-toggle="buttons">
						<label id="lbl_alunos" class="btn btn-primary active">
							<input type="radio" name="busca_alunos" value="alunos" id="cbx_alunos" autocomplete="off" checked="checked">Alunos
						</label>
						<label id="lbl_turmas" class="btn btn-primary">
							<input type="radio" name="busca_turmas" value="turmas" id="cbx_turmas" autocomplete="off">Turmas
						</label> 
						<label id="lbl_questionarios" class="btn btn-primary">
							<input type="radio" name="busca_questionarios" value="questionarios" id="cbx_questionarios" autocomplete="off">Questionários
						</label>
					</div>
					</center>
				</div>
			</div> <!-- Row End -->
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");    

			function apresentaNotas(url){
				var linhas = "";
				$.ajax({
					type: "POST",
					url: "scripts/" + url,
					dataType: "json",
					success: function(retorno){
						if(retorno == 0){
							
						}
					}
				});
			}

        </script>        
    </body>
</html>    