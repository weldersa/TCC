<!DOCTYPE html>
<?php
     // Inicia a Sessão
	session_start();
?>

<html lang="pt-BR">
    <head>

        <script>
            var countdown = 4;
            var timer = setInterval(function(){
                $('#countdown').text(countdown--);
                if(countdown < 0){
                    window.location.href=$('#redirect').prop('href');
                }
            },1000);

        </script>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" charset="UTF-8"> <!-- Atributos padrão do site -->
        
        <title>Cadastre-se</title>
        
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/jasny-bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/cadastro.css">
        <link rel="icon" href="resources/images/favicon.ico"> 
        
        <script type="text/javascript" src="js/jquery-1.12.2.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default"> <!-- Começo da Barra de Navegação -->
            <div class="container-fluid">
                <div class="navbar-header navbar-left pull-left">
                    <a class="navbar-brand" href="index.php" style="padding-top: 0px;">	
						<img alt="brand" src="resources/images/logo-color-sm.png" height="50px" style="padding-top: 3px;">
				    </a>
                </div>
                <form action="index.php" class="navbar-header pull-right">                
                    <button type="submit" id="btn_login" class="btn btn-success pull-left" href="index.php">Login</button>
                </form>
            </div>
        </nav>
        
        <div class="container">
            <div class="wrapper">
                <div class="form-signin" id="form_cadastro">
                    <div id="txtLogin" class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <center><h2 class="form-signin-heading"><?php echo $_SESSION['msg_cadastro']; ?></h2></center>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <center>
                                Você será redirecionado em <span id="countdown">5</span> segundos.<br>
                                Caso isso não aconteça, 
                                
                                <?php
                                    if($_SESSION['msg_cadastro'] == "Instituicao Cadastrada com Sucesso!"){
                                        echo "<a id='redirect' href='index.php'>clique aqui</a>";
                                    }else{
                                        echo "<a id='redirect' href='cadastro.php'>clique aqui</a>";
                                    }
                                    unset($_SESSION['msg_cadastro']);
                                ?>
                                
                                </center>
                            </div>
                        </div>
                        
                    </div>                    
                </div>
            </div>    
        </div> <!-- /container -->
    </body>
</html>