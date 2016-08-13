<!--
DATA: 03/05/16    
ARQUIVO: home.php
DESCRIÇÃO: Página de início, primeira página após o login
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
        <title>Pagina Principal</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            
                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");                   
        </script>        
    </body>
</html>    