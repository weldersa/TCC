<!--
DATA: 10/08/16
ARQUIVO: permission_denied.php
DESCRIÇÃO: Página de erro de permissão negada
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
        <title>Permissão Negada</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
			<div id='wrap'>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<p class="text-center">
								<span class="text-info" style="font-size: 4em;">Ops... 403 <i class="fa fa-frown-o"></i>
								</span>
							</p>
							<p class="text-center">
								Infelizmente você não possui permissão para acessar essa página!
							</p>
							<p class="text-center">Caso seja um usuário do tipo "Professor", <a href="mailto:dev-frage@gmail.com.br?subject=Erro 403">clique aqui para reportar um erro.</a></p>
						</div>
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