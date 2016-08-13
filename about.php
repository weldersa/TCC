<!--
DATA: 31/07/16    
ARQUIVO: about.php
DESCRIÇÃO: Página com a descrição do projeto
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
			<div id="div_about">
				<h3>Frage</h3>
				<b>Sistema web para a criação e resolução de questionários</b>
				<br><br>
				<span>
					Sistema desenvolvido para apresentação do Projeto de TCC para o 
					Curso de Bacharelado em Sistemas de Informação - Faculdade de Hortolândia
				</span>
				<br><br>
				<span>
					<b>Autores:</b>
					<br><br>
					Gustavo Mendes da Silva
					<br>
					Welder Silvestre Azevedo
			</div>
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#home").removeClass("active");
            $("#criar_questionario").removeClass("active");
			$("#about").addClass("active");                   
        </script>        
    </body>
</html>    