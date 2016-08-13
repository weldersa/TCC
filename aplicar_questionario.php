<!--
DATA: 31/07/16    
ARQUIVO: aplicar_questionario.php
DESCRIÇÃO: Página para aplicar questionários
-->

<!DOCTYPE html>
<?php
	//Imports		
	require_once "classes/conexao.class.php";

	// Inicia a Sessão
	session_start();
    
    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

	//Coleta data para colocar no placeholder para navegadores sem campo "date-time-local"
    date_default_timezone_set("America/Sao_Paulo");
    $date = date('d/m/Y');
    $time = date('H:i');

?>

<html lang="pt-BR">
    <head>
        <title>Aplicar Questionário</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página -->
            <div class="container-fluid">
				<br>
				<div id="alerta_aplicar_sucesso" class="alert alert-success" role="alert">
					<span><center>Questionário aplicado com sucesso!</center></span>
				</div>
				<div id="alerta_aplicar_erro" class="alert alert-danger" role="alert">
					<center><span><!-- Onde vai aparecer a mensagem de erro --></span></center>
				</div>
				<div class="row">
                    <div class="col-md-12 col-xs-12">
						<h3>Aplicar um Questionário:</h3>
						<br>
                    </div>
                </div> <!-- Row End -->
				<form id="form_aplicar" action="#">
					<div class="row">
						<div class="col-md-12 col-xs-12">
								<label>Questionário:</label>
								<br>
								<input type="hidden" id="txt_codigo_questionario" name="txt_codigo_questionario" value="<?php echo $_POST["cod_questionario"]; ?>" read only/>
								<span><?php echo $_POST["cod_questionario"]." - ".$_POST["quest_nome"]; ?></span>
							<br><br>
						</div>
					</div> <!-- Row End -->
					<div class="row">
						<div class="col-md-12 col-xs-12">
							Selecione a turma para qual deseja aplicar o questionário acima:
							<select id="slc_turma" class="form-control">
								<?php
									$conexao = new Conexao();

									$resultado = $conexao->executaComando("SELECT * FROM turmas WHERE turma_instituicao=".$_SESSION["user_instituicao"].";");

									while($linha = mysqli_fetch_array($resultado)){
										//Adiciona "0" no início do código até ficar com 5 dígitos
										$cod_turma = str_pad($linha["turma_codigo"], 5, "0", STR_PAD_LEFT);
										echo "<option>".$cod_turma." - ".$linha["turma_nome"]."</option>";
									}
								?>
							</select>
						</div>
					</div> <!-- Row End -->
					<br>
					<label for="txt_data_limite" id="label_data_limite">Data Inicial para Resposta</label>
					<div class="row">                        
						<div class="col-md-6 col-xs-12">
							<div class='input-group'>
								<span class="input-group-addon">Data:</span>
								<input type="date" class="form-control" id="txt_data_inicio" name="txt_data_inicio" <?PHP echo "placeholder='".$date."'"; ?> required>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class='input-group'>                                
								<span class="input-group-addon">Hora:</span>
								<input type="time" class="form-control" id="txt_hora_inicio" name="txt_hora_inicio" <?PHP echo "placeholder='".$time."'"; ?> required>
							</div>
						</div>
					</div> <!-- Row End -->
					<label for="txt_data_limite" id="label_data_limite">Data Final para Resposta</label>
					<div class="row">                        
						<div class="col-md-6 col-xs-12">
							<div class='input-group'>
								<span class="input-group-addon">Data:</span>
								<input type="date" class="form-control" id="txt_data_fim" name="txt_data_fim" <?PHP echo "placeholder='".$date."'"; ?> required>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class='input-group'>                                
								<span class="input-group-addon">Hora:</span>
								<input type="time" class="form-control" id="txt_hora_fim" name="txt_hora_fim" <?PHP echo "placeholder='".$time."'"; ?> required>
							</div>
						</div>
					</div> <!-- Row End -->
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<br>
							<div class="pull-right">
								<button type="button" id="btn_voltar" class="btn btn-danger">Voltar</button>
								<button type="submit" id="btn_aplicar" class="btn btn-success">Aplicar</button>
							</div>
						</div>
					</div> <!-- Row End -->
				</form>
			</div>                      
        </div> <!-- Fim do Conteúdo da página -->
        
        <!-- Importa o plugin de mascara -->
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
		<script type="text/javascript" src="js/bootbox.min.js"></script>

        <script> 
			$("#btn_voltar").click(function(){
				window.history.back(-1);
			});

            //Muda o Link Ativo no Menu lateral
            $("#meus_questionarios").addClass("active");
            $("#opcoes_questionario").collapse("show");
            $("#teste").addClass("active");  
            $("#home").removeClass("active");  

            //Adiciona mascara nos campos dataTime quando o navegador não suportar o campo html5 (IE)
            if (($("#txt_data_fim").prop("type") == "text") && ($("#txt_data_inicio").prop("type") == "text")){
                $("#txt_data_fim").mask("99/99/9999");
                $("#txt_data_inicio").mask("99/99/9999");
            }
            
            if (($("#txt_hora_fim").prop("type") == "text") && ($("#txt_hora_inicio").prop("type") == "text")){
                $("#txt_hora_fim").mask("99:99");
                $("#txt_hora_inicio").mask("99:99");
            }    

			function verificaQuestionario(){

			}
			
			$("#form_aplicar").submit(function(event){
				event.preventDefault();

				var cod_questionario = $("#txt_codigo_questionario").val();
				 
				var cod_turma = $("#slc_turma").val();
				//Retira só o código da turma da seleção
				var arr = cod_turma.split(" -");
				cod_turma = arr[0];
				
				var data_inicio = $("#txt_data_inicio").val();
				var hora_inicio = $("#txt_hora_inicio").val();
				var data_fim = $("#txt_data_fim").val();
				var hora_fim = $("#txt_hora_fim").val();
				
				var dataString = "cod_questionario="+cod_questionario+"&cod_turma="+cod_turma+"&data_inicio="+data_inicio+
				"&hora_inicio="+hora_inicio+"&data_fim="+data_fim+"&hora_fim="+hora_fim;
				
				$.ajax({
					type: "POST",
					url: "scripts/aplicarQuestionarioAjax.php",
					data: dataString,
					success: function(data){
						if(data == "true"){

							var box = bootbox.dialog({
								message: "Questionário aplicado com sucesso! <br> Deseja aplicar esse questionário para outra turma?", 
								buttons: {
									danger: {
										label: "Não",
										className: "btn_nao",
										callback: function(){
											window.location.href = "meus_questionarios.php";
										}
									},
									main: {
										label: "Sim",
										className: "btn_sim",
										callback: function(){
											$("#form_aplicar")[0].reset();
										}
									}
								}
							});

							box.find('.modal-content').addClass("alert-success");
							box.find('.modal-content').css({
								"background-color" : "#dff0d8",
								"text-align" : "center",
							});
													
							
						}else{
							var box = bootbox.dialog({
								message: data,
							});

							box.find('.modal-content').addClass("alert-danger");
							box.find('.modal-content').css({
								"background-color" : "#f2dede",
								"text-align" : "center",
							});
						}
					}
				});
			});
        </script>        
    </body>
</html>