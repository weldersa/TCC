<!--
DATA: 03/05/16    
ARQUIVO: index.php
DESCRIÇÃO: Página de Login do Site
--> 

<!DOCTYPE html>

<?php
	// Inicia a Sessão
	session_start();
    // Testa se o usuário está logado
    if(!empty($_SESSION['user_email'])){
		header('Location: home.php');
	}
?>

<html lang="pt-BR">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset="UTF-8"> <!-- Atributos padrão do site -->
        
        <title>Frage - Login</title>
        
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/jasny-bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/login.css">
        <link rel="apple-touch-icon" sizes="180x180" href="/resources/icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="/resources/icons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/resources/icons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="/resources/icons/manifest.json">
        <link rel="mask-icon" href="/resources/icons/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="/resources/icons/favicon.ico">
        <meta name="msapplication-config" content="/resources/icons/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
        
        <script type="text/javascript" src="js/jquery-1.12.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        
        <script>
            $(document).ready(function(){
                $("#btnLogin").click(function(){
                    var email = $("#txtEmail").val();
                    var senha = $("#txtSenha").val();
                                    
                    var dataString = "email="+email+"&senha="+senha;
                    
                    if($.trim(email).length>0 && $.trim(senha).length>0){
                        $.ajax({
                            type: "POST",
                            url: "scripts/login.php",
                            data: dataString,
                            cache: false,
                            beforeSend: function(){ $("#btnLogin").val("Entrando...");},
                            success: function(data){
                                if(data){
                                    console.log("Login efetuado com sucesso!");
                                    window.location.href="home.php";
                                } else{
                                    console.log("Usuário ou Senha incorretos.");
                                    $("#btnLogin").val("Login");
                                    $('#txtLogin').addClass('has-error');
                                    $('#erro_login').removeClass('sr-only');
                                }
                            }
                        });
                    }
                    return false;
                });
            });            
        </script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top"> <!-- Começo da Barra de Navegação -->
            <div class="container-fluid">
                <div class="navbar-header navbar-left pull-left">
                    <a class="navbar-brand" href="#" style="padding-top: 0px;">	
						<img alt="brand" src="resources/images/logo-color-sm.png" height="50px" style="padding-top: 3px;">
				    </a>
                </div>
                <form action="cadastro.php" class="navbar-header pull-right">                
                    <button type="submit" id="btn_registro" class="btn btn-success pull-left" href="cadastro.php">Cadastrar Instituição</button>
                </form>
            </div>
        </nav>
        <div class="container">
        <img src="resources/images/login-background-lg.jpg" class="full-bg animation-pulseSlow"/>
            <div class="wrapper">
                <form class="form-signin" id="form_login" method="POST" action="">
                    <div id="txtLogin" class="form-group">
                        <center><h2 class="form-signin-heading">Bem Vindo ao Frage!</h2></center>
                        <center><span class="sr-only" id="erro_login">Usuário ou Senha incorretos</span></center>
                        <input type="email" name="txtEmail" id="txtEmail" class="form-control" placeholder="Endereço de email" required autofocus>
                        <input type="password" name="txtSenha" id="txtSenha" class="form-control" placeholder="Senha" required>
                    </div>
                    <div class="checkbox pull-left">
                        <label>
                            <input id="cbxLembrar" type="checkbox" value="remember-me"> Permanecer logado
                        </label>
                    </div>
                    <div>
                        <label class="checkbox pull-left">
                            <a id="esqueciSenha" href="passRecover.php">Esqueci a senha</a>
                        </label>
                    </div>
                    <input value="Login" id="btnLogin" class="btn btn-lg btn-primary btn-block" type="submit">
                </form>
            </div>            
        </div> <!-- /container -->        
    </body>
</html>



