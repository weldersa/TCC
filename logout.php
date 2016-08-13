<!--
DATA: 03/05/16    
ARQUIVO: logout.php
DESCRIÇÃO: Realiza o logoff do usuário e redireciona para a página de login.
--> 

<?PHP
    session_start(); //Inicia a sessão
    session_destroy(); //Destroi a sessão
    session_unset(); //Limpa as variáveis da sessão
    header('location: index.php'); //Redireciona para a página de login
?>