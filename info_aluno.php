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

$email = $_GET['email'];
$conexao = new Conexao();
$resultado = $conexao->executaComando("SELECT usuarios.user_email, usuarios.user_nome, alunos.aluno_sobrenome, alunos.aluno_ra, alunos.aluno_rg, alunos.aluno_cpf FROM usuarios INNER JOIN alunos ON usuarios.user_email=alunos.aluno_email WHERE user_email = '$email'");
$linha = mysqli_fetch_array($resultado);
$nome = $linha['user_nome']." ".$linha['aluno_sobrenome'];
$email = $linha['user_email'];
$ra = $linha['aluno_ra'];
$rg = $linha['aluno_rg'];
$cpf = $linha['aluno_cpf'];

if(isset($_POST['turma'])){
	$turma = $_POST['turma'];
	$resultado4 = $conexao->executaComando("SELECT * FROM aluno_turma WHERE aluno_email = '$email' AND turma_codigo = $turma; ");
	if(mysqli_num_rows($resultado4) == 0){
		$conexao->executaComando("INSERT INTO aluno_turma VALUES('$email', $turma);");
	}else{
		echo "<script>alert('Esse aluno já está matriculado nessa turma.')</script>";
	}
}

$resultado2 = $conexao->executaComando("SELECT turmas.turma_codigo , turmas.turma_nome FROM turmas INNER JOIN aluno_turma ON turmas.turma_codigo=aluno_turma.turma_codigo WHERE aluno_email='$email'");

?>

<html lang="pt-BR">
    <head>
        <title>Alunos</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="row">
				<div class="col-md-12">
					<center><h3> <?php echo $nome; ?> </h3><center>
				</div> <!-- DIV COL -->
			<div> <!-- DIV ROW -->

			<div class="row col-md-12"><br><br></div>

			<center><div class="container-fluid">
				<?php
					echo "<b>Email: </b>$email<br>
						<b>RA: </b>$ra<br>
						<b>RG: </b>$rg<br>
						<b>CPF: </b>$cpf<br><br>
						<b>Turmas: <br></b>";
						if(mysqli_num_rows($resultado2) == 0){
							echo "Não matriculado em nenhuma turma.<br>";
						}
						while($linha = mysqli_fetch_array($resultado2)){
							echo "$linha[turma_nome]"."<br>";
						}
					
				?>
				<br><input type="button" id="btn_cadastrar_aluno" data-toggle="modal" data-target="#myModal" class="btn btn-success pull-right" value="Inserir em Turma">
			</div></center>
		
			<div class="container">

				<!-- Modal -->
				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">
					
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Inserir aluno em turma</h4>
						</div>
						<div class="modal-body">
						<p>Escolha a turma para adicionar o aluno:</p><br>
						<form method="POST" action="#">
							<select name="turma" class="form-control" required>
								<option value="">--- Escolha uma Turma ---</option>
								<?php
									$resultado3 = $conexao->executaComando("SELECT * FROM turmas;");
									while($linha = mysqli_fetch_array($resultado3)){
										echo "<option value='$linha[turma_codigo]'>$linha[turma_nome]</option>";
									} 
								?>
							</select>
							
						</div>
						<div class="modal-footer">
						<button type="submit" class="btn btn-success">Adicionar</button>
						</form>
						</div>
					</div>
					
					</div>
				</div>
				
				</div>

        </div> <!-- Fim do Conteúdo da página -->
    </body>
	<script>
	</script>
</html>