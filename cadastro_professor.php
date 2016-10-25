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
        <title>Cadastro de Professores</title>
        <?PHP include 'imports.html'; ?>
		<link rel="stylesheet" href="css/cadastro_aluno_professor.css">
		<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
          	<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						 <h3>Cadastrar Professor</h3>
					</div>
				</div>	
				<form id="cadastrar_aluno" action="cadastrando_aluno.php" method="POST">				
					<div class="row">
						<div class="col-md-6">
							<label for="txt_professor_nome">Nome:</label>
							<input type="text" class="form-control" id="txt_professor_nome">
						</div>
						<div class="col-md-6">
							<label for="txt_aluno_sobrenome">Sobrenome:</label>
							<input type="text" class="form-control" id="txt_professor_sobrenome">
						</div>
					</div>
					<div id="div_professor_email" class="row">
						<div class="col-md-12">
							<label for="txt_email">Email:</label>
							<input type="text" class="form-control" name="txt_email" id="txt_email" required>
							<label id="email_uso" class="label_aviso sr-only control-label">Email em uso!</label>
							<label id="email_valido" class="label_aviso sr-only control-label">Email disponível</label>
							<label id="email_invalido" class="label_aviso sr-only control-label">Email inválido</label>
						</div>
					</div>
					<div id="div_senha">
						<div class="row">
							<div class="col-md-6">
								<label for="txt_senha1">Senha:</label>
								<input type="password" class="form-control" name="txt_senha1" id="txt_senha1" required>
								<label class="label_aviso control-label" id="erro_senha">As senhas não coincidem!</label>
								<label class="label_aviso control-label" id="erro_senha2">A senha precisa ter pelo menos 8 caracteres!</label>
							</div>
							<div class="col-md-6">
								<label for="txt_senha2">Confirme a Senha:</label>
								<input type="password" class="form-control" name="txt_senha2" id="txt_senha2" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="txt_professor_cpf">CPF:</label>
							<input type="text" class="form-control" id="txt_professor_cpf">
						</div>
						<div class="col-md-6">
							<label for="txt_professor_rg">RG:</label>
							<input type="text" class="form-control" id="txt_professor_rg">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<br><br>
							<input type="submit" value="Cadastrar" class="btn btn-success pull-right">
						</div>
					</div>
				</form> 
			</div>
                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");       

			var chk_email = false;
			function testaEmail(){
				var x = $('#txt_email').val();
				var atpos = x.indexOf("@");
				var dotpos = x.lastIndexOf(".");

				if(x.length > 0){
					if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length){     //Não é um email
						$('#email_uso').addClass('sr-only');
						$('#email_valido').addClass('sr-only');
						$('#email_invalido').removeClass('sr-only');
						$('#div_professor_email').addClass('has-error');
						chk_email = false;
					}else{                                          //É um email
						var dataString = "txt_email="+$("#txt_email").val();

						$.ajax({
							type: "POST",
							url: "scripts/chk_email.php",
							data: dataString,
							dataType: "json",
							success:function(data){
								if(data == 0){                      //Email válido
									$('#email_uso').addClass('sr-only');
									$('#email_valido').removeClass('sr-only');
									$('#div_professor_email').addClass('has-success');
									$('#div_professor_email').removeClass('has-error');
									$('#email_invalido').addClass('sr-only');
									chk_email = true;
								}else{
									$('#email_uso').removeClass('sr-only');
									$('#email_valido').addClass('sr-only');
									$('#div_professor_email').addClass('has-error');
									$('#div_professor_email').removeClass('has-success');
									$('#email_invalido').addClass('sr-only');
									chk_email = false;
								}
							}
						});
					}
				}else{ 
					$('#email_uso').addClass('sr-only');
					$('#email_valido').addClass('sr-only');
					$('#email_invalido').addClass('sr-only');
					$('#div_professor_email').removeClass('has-success');
					$('#div_professor_email').removeClass('has-error');
					chk_email = false;
				}
			}    
			$('#txt_email').on('input', function(){
				testaEmail();
			});   


			var chk_senha = false;
			function verifica_senha(){
					if($('#txt_senha1').val().length < 8){
						$('#div_senha').addClass('has-error');
						$('#erro_senha2').show();
						chk_senha = false;
					}else if($('#txt_senha1').val() != $('#txt_senha2').val()){
						$('#div_senha').addClass('has-error');
						$('#erro_senha').show();
						$('#erro_senha2').hide();
						chk_senha = false;
					}else{
						$('#div_senha').removeClass('has-error');
						$('#erro_senha').hide();
						$('#erro_senha2').hide();
						chk_senha = true;
					}
			}

			$('#txt_senha1').on('input', function(){
				verifica_senha();
			});

			$('#txt_senha2').on('input', function(){
				verifica_senha();
			});

			$('#txt_professor_cpf').mask("999.999.999-99");            
        </script>        
    </body>
</html>    