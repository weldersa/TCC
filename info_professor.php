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
$resultado = $conexao->executaComando("SELECT usuarios.user_email, usuarios.user_nome, professores.professor_sobrenome, professores.professor_rg , professores.professor_cpf FROM usuarios INNER JOIN professores ON usuarios.user_email=professores.professor_email WHERE user_email = '$email'");
$linha = mysqli_fetch_array($resultado);
$nome = $linha['user_nome']." ".$linha['professor_sobrenome'];
$email = $linha['user_email'];
$rg = $linha['professor_rg'];
$cpf = $linha['professor_cpf'];      

?>

<html lang="pt-BR">
    <head>
        <title>Informações do Professor</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="row">
				<div class="col-md-12">
					<center><h3> <?php echo $nome; ?> </h3><center>
					<center><h5> Professor </h5></center>
				</div> <!-- DIV COL -->
			<div> <!-- DIV ROW -->

			<div class="row col-md-12"><br><br></div>

			<center><div class="container-fluid">
				<?php
					echo "<b>Email: </b>$email<br>
						<b>RG: </b>$rg<br>
						<b>CPF: </b>$cpf<br><br>";
				?>
			</div></center>
		
			
        </div> <!-- Fim do Conteúdo da página -->
    </body>
	<script>
	</script>
</html>