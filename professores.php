<!DOCTYPE html>
<?php
include 'classes/conexao.class.php';
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
        <title>Professores</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="row">
                <div class="col-md-12">
                    <h3>Professores</h3>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">

					<br>

					<div class="table-responsive">
						<table id="tabela" class="table tablesorter">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Email</th>
									<th>RG</th>
									<th>CPF</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$query = ("SELECT usuarios.user_email, usuarios.user_nome, professores.professor_sobrenome, professores.professor_rg, professores.professor_cpf, professores.professor_instituicao FROM usuarios INNER JOIN professores ON usuarios.user_email=professores.professor_email WHERE professor_instituicao = $_SESSION[inst_codigo];");
									$conexao = new Conexao();
									$resultado = $conexao->executaComando($query) or die("Erro ao Buscar Professores.");
									if($resultado){
										while($linha = mysqli_fetch_array($resultado)){
											$email = $linha['user_email'];
											echo "
												<tr id='tabela' class='tabela_tr clickable-row' data-href='info_professor.php?email=$email'>
													<td>$linha[user_nome] $linha[professor_sobrenome]</td>
													<td>$linha[user_email]</td>
													<td>$linha[professor_rg]</td>
													<td>$linha[professor_cpf]</td>
													<input type='hidden' value='$linha[user_email]' name='email'/>
												</tr>";
										}
									}
								?>
							</tbody>
						</table>
					</div> <!-- FIM DIV TABLE -->
                </div> <!-- FIM DIV COL -->
            </div>
			<div class="row">
                <div class="col-md-12">
                    <input type="button" id="btn_cadastrar_professor" class="btn btn-success pull-right" value="Cadastrar Professor">
                </div>
            </div>
        </div> <!-- Fim do Conteúdo da página -->
    </body>
	<script>
		$('#btn_cadastrar_professor').click(function(){
			window.location.href = "cadastro_professor.php";
		});

		$(".clickable-row").click(function() {
			window.document.location = $(this).data("href");
		});

	</script>
</html>