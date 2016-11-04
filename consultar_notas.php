<!--
DATA: 03/05/16    
ARQUIVO: home.php
DESCRIÇÃO: Página de início, primeira página após o login
-->

<!DOCTYPE html>
<?php
include "classes/conexao.class.php";
	// Inicia a Sessão
	session_start();

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

$conexao = new Conexao();
$resultado = $conexao->executaComando("SELECT * FROM notas WHERE user_email = '$_SESSION[user_email]'");

?>

<html lang="pt-BR">
    <head>
        <title>Consultar Notas</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
			<div class="row">
				<div class="col-md-12">
					<?php
						if($_SESSION['user_tipo'] == 'P'){
							echo "<h3>Buscar notas:</h3>";
						}
						if($_SESSION['user_tipo'] == 'I'){
							echo "<h3>Buscar notas:</h3>";
						}
						if($_SESSION['user_tipo'] == 'A'){
							echo "<h3>Buscar notas:</h3>";
						}
					?>
				</div>
			</div> <!-- Row End -->
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<center>
					<div id="buscar_notas" class="btn-group" data-toggle="buttons">
						<div id="div_busca_notas" class="input-group">
							<input type="text" id="txt_busca" name="txt_busca" class="form-control"/>
							<select id="slc_opcaoBusca" name="slc_opcaoBusca" class="form-control">
								
								<?php

									if($_SESSION['user_tipo'] == 'I'){
										?>
											<option value='questionarios.quest_nome'>Questionário</option>
											<option value='materias.materia_nome'>Matéria</option>
											<option value='concat (usuarios.user_nome, ' ', alunos.aluno_sobrenome)'>Aluno</option>
											<option value='professores.professor_email'>Professor</option>
										<?php	
									}

									if($_SESSION['user_tipo'] == 'P'){
										?>
											<option value='questionarios.quest_nome'>Questionário</option>
											<option value='materias.materia_nome'>Matéria</option>
											<option value="concat (usuarios.user_nome, ' ', alunos.aluno_sobrenome)">Aluno</option>
										<?php
									}

									if($_SESSION['user_tipo'] == 'A'){
										?>
											<option value='questionarios.quest_nome'>Questionário</option>
											<option value='materias.materia_nome'>Matéria</option>
										<?php
									}

								?>
							
							</select>
							<span class="input-group-btn">
								<button id="btn_buscar" class="btn btn-primary">Buscar</button>
							</span>
						</div>
					</div>
					</center>
				</div>
			</div> <!-- Row End -->
				<br>
			<div class="row">
				<div class="col-md-12">
					<table id="tabela_notas_alunos" class="table tablesorter">
						<thead>
							<?php
								if($_SESSION['user_tipo'] == 'A'){
									echo "<th>Questionário</th>
									<th>Professor</th>
									<th>Matéria</th>
									<th>Data que foi respondido</th>
									<th>Nota</th>";
								}
								if($_SESSION['user_tipo'] == 'P'){
									echo "<th>Aluno</th>
									<th>Questionário</th>
									<th>Matéria</th>
									<th>Data que foi respondido</th>
									<th>Nota</th>";
								}
								if($_SESSION['user_tipo'] == 'I'){
									echo "<th>Questionário</th>
									<th>Professor</th>
									<th>Matéria</th>
									<th>Data que foi respondido</th>
									<th>Nota</th>";
								}
							?>
						</thead>
						<tbody id="corpo_tabela">
							<tr id='tr_sem_notas'>
								
							</tr>
						</tbody>
					</table>
				</div>
			</div>
        </div> <!-- Fim do /Conteúdo da página -->
        
        <script> 
            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");    

			$('#tabela_notas_alunos').tablesorter();

			$(document).ready(function(){
				notas_alunos();
			});

			$('#lbl_alunos').click(function(){
				notas_alunos();
			});

			$('#txt_busca').keypress(function(e){
				 if(e.which == 13) {
					notas_alunos();
				 }
			});

			$('#btn_buscar').click(function(){
				notas_alunos();
			});

			function notas_alunos(){
				var usuario_tipo = '<?php echo $_SESSION['user_tipo']; ?>';
				var select = $('#slc_opcaoBusca').val();
				var busca = $('#txt_busca').val();
				var linhas = "";
				$.ajax({
					type: "POST",
					url: "scripts/notas_alunos.php",
					data: "slc_opcaoBusca="+select+"&txt_busca="+busca,
					dataType: "json",
					success: function(retorno){
						if(retorno == 0){
							linhas += "<td colspan='5'><center>Nenhuma nota encontrada</center></td>";
						}else{
							var contador = 1;
							retorno.forEach(function(item){
								if(usuario_tipo == 'A'){
									linhas += "<tr>";
										linhas += "<td>"+item['quest_nome']+"</td>";
										linhas += "<td>"+item['quest_professor']+"</td>";
										linhas += "<td>"+item['quest_materia']+"</td>";
										linhas += "<td>"+item['data_resposta']+"</td>";
										linhas += "<td>"+item['nota_valor']+"</td>";
									linhas += "</tr>";
								}
								if(usuario_tipo == 'P'){
									linhas += "<tr>";
										linhas += "<td>"+item['quest_aluno']+" "+item['aluno_sobrenome']+"</td>";
										linhas += "<td>"+item['quest_nome']+"</td>";
										linhas += "<td>"+item['quest_materia']+"</td>";
										linhas += "<td>"+item['data_resposta']+"</td>";
										linhas += "<td>"+item['nota_valor']+"</td>";
									linhas += "</tr>";
								}
								if(usuario_tipo == 'I'){
									linhas += "<tr>";
										linhas += "<td>"+item['quest_nome']+"</td>";
										linhas += "<td>"+item['quest_professor']+"</td>";
										linhas += "<td>"+item['quest_materia']+"</td>";
										linhas += "<td>"+item['data_resposta']+"</td>";
										linhas += "<td>"+item['nota_valor']+"</td>";
									linhas += "</tr>";
								}
							});
						
						}
						
						$('#corpo_tabela').empty();
						$('#corpo_tabela').html(linhas);

					}
				});
			}

        </script>        
    </body>
</html>    