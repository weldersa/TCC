<!--
DATA: 25/05/16    
ARQUIVO: sumario_questionario.php
DESCRIÇÃO: Página de sumario de Questionários
-->   

<?PHP
    //Inicia a sessão
    session_start();

	if($_SESSION["user_tipo"] != "P"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
	}    
?>

<html>
    <head>
        <?PHP include 'imports.html'; ?>
        <title>Corrigir Questionários</title>
    </head>
    <body>
        <?PHP include 'menu.php'; ?>
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h3>Questionários com Correção Pendente:</h3>
						<br><br>
                    </div>
                </div> <!-- Row End -->
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="panel-group" id="panel_perguntas">
							<div class="panel panel-default">
								<div class="panel-heading div_panel">
									<span> Não há questionários para corrigir </span>
								</div>
							</div>
						</div>
					</div>
				</div>                        
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div id="div_botoes_sumario">
                            <button class="btn btn-primary" id="btn_addPergunta">Meus Questionários</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $("#btn_addPergunta").click(function(){
                    window.location.href = "criar_pergunta.php";
                });
                
                $("#btn_finalizaQuest").click(function(){
                    alert("Não é possível finalizar o questionário sem criar nenhuma pergunta.");
                });
            });
        </script>
    </body>
</html>