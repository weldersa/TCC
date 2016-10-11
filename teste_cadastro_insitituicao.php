<html>
	<head>
		<title>Cadastro</title>
	</head>
	<body>
		<form id="cadastro" method="POST" action="#" target="_self">
			<input type="text" placeholder="Nome" name="nome" id="nome"><br>
			<input type="text" placeholder="Rua" name="rua" id="rua"><br>
			<input type="text" placeholder="Numero" name="numero" id="numero"><br>
			<input type="text" placeholder="CEP" name="cep" id="cep"><br>
			<input type="text" placeholder="Bairro" name="bairro" id="bairro"><br>
			<input type="text" placeholder="Cidade" name="cidade" id="cidade"><br>
			<input type="text" placeholder="Estado" name="estado" id="estado"><br>
			<input type="text" placeholder="Pais" name="pais" id="pais"><br>
			<input type="text" placeholder="Telefone" name="telefone" id="telefone"><br>
			<input type="text" placeholder="Email" name="email" id="email"><br>
			<input type="text" placeholder="Login" name="login" id="login"><br>
			<input type="text" placeholder="Senha" name="senha" id="senha"><br>
			<input type="text" placeholder="CNPJ" name="cnpj" id="cnpj"><br><br>
			<button type="submit" name="cadastro" value="Dilma">Dilma</button>
		</form>
		
		
		<body>
	<div class="conteiner">
		<div class="conteiner-fluid">
			<div class="row">
				<div class="col-md-6">
					Conteúdo
				</div>
				<div class="col-md-3">
					Contéudo 2
				</div>
				<div class="col-md-3">
					Conteúdo 3
				</div>
			</div>
		</div>
	</div>
</body>
		
		<?PHP
			if( $_SERVER['REQUEST_METHOD'] == 'POST'){		
				require_once "classes/instituicao.class.php";
				
				$inst = new Instituicao($_POST['nome'], $_POST['rua'], $_POST['numero'], $_POST['cep'], $_POST['bairro'], $_POST['cidade'], $_POST['estado'], $_POST['pais'], $_POST['telefone'], $_POST['email'], $_POST['login'], $_POST['senha'], $_POST['cnpj']);				
				$inst->insertInst();
			}
		?>		
	</body>
</html>