<!--
DATA: 14/05/16    
ARQUIVO: criar_pergunta.php
DESCRIÇÃO: Página de criação de Perguntas
-->   
<!DOCTYPE html>
<?php
    //Imports
    require_once "classes/questionario.class.php";
    require_once "classes/pergunta.class.php";
    require_once "classes/pergunta_alternativa.class.php";
    require_once "classes/conexao.class.php";

    // Inicia a Sessão
	session_start();

	if($_SESSION["user_tipo"] != "P"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }

    //Instância objeto Questionário e recebe seus valores da Sessão    
    $questionario = new Questionario();
    $questionario = unserialize($_SESSION["questionario"]);

    //Recebe número de perguntas que o questinoário já tem e adiciona +1, salva esse valor em "numDaPergunta"
    $numDaPergunta = $_SESSION["numPerguntas"] + 1;
    
    //Cria um vetor com os objetos do tipo "Pergunta" e recebe seu valor da sessão
    $perguntas = unserialize($_SESSION["perguntas"]);
    
    //Instância objeto do tipo "Pergunta" para armazenar valores da pergunta atual
    $perguntaAtual = new Pergunta();     
    
    //Cria um vetor com os objetos do tipo "Pergunta_alternativa" e recebe seu valor da sessão
    $perguntas_alternativas = unserialize($_SESSION["perguntas_alternativas"]);
    
    //Instância objeto do tipo "Pergunta_alternativa" para armazenar alternativas da pergunta atual
    $alternativas = new Pergunta_alternativa(); 

    $conexao = new Conexao();


    //Bloco de código que vai ser executado após o "POST" ser enviado pelo formulário
    if( $_SERVER['REQUEST_METHOD'] == 'POST'){  
        //Testa se a pergunta é de Alternativas, para poder criá-las
        if(($_POST["tipo_pergunta"] == "Alternativa") || ($_POST["tipo_pergunta"] == "Verdadeiro/Falso")){
            
            //Cria vetor onde vai ficar armazenado se cada alternativa é correta ou não
            $altCorretas = array();
            
            //Percorre as alternativas para verificar se elas são corretas ou não, e salva essas informações no vetor
            if($_POST["tipo_pergunta"] == "Alternativa"){
                for($i = 1; $i <= $_POST["num_alternativas"]; $i++){
                    if($_POST["alt_correta"] == $i){
                        $altCorretas[$i] = 1;
                    }else{
                        $altCorretas[$i] = 0;
                    }
                }
            }else if($_POST["tipo_pergunta"] == "Verdadeiro/Falso"){
                    for($i = 1; $i <= $_POST["num_alternativas"]; $i++){
                        if($_POST["chk_alternativa_".$i] == "true"){
                            $altCorretas[$i] = 1;
                        }else{
                            $altCorretas[$i] = 0;
                        }
                    }   
            } // fim do IF
            
            $perguntaAtual->setNumAlternativas($_POST['num_alternativas']);

            //Salva as alternativas no objeto alternativa
            for($i = 1; $i <= $_POST["num_alternativas"]; $i++){
                $alternativas->setAlternativa($i, $numDaPergunta, $_POST['txt_alternativa_'.$i], $altCorretas[$i]);    
            }    
        }else{
            //Define que o questionário precisa de correção, pois tem perguntas dissertativas
            $questionario->setNecessitaCorrecao(1);
            $perguntaAtual->setNumAlternativas(0);
        }
        
        //Salva as informações da pergunta no objeto pergunta
        $perguntaAtual->setEnunciado($_POST['txt_enunciado']);
        $perguntaAtual->setNumPergunta($numDaPergunta);
        $perguntaAtual->setTipo($_POST['tipo_pergunta']);
        
        //Opcional
        $imagem = array(
            "type" => "image/".$_POST["txt_tipo_imagem"],
            "tmp_name" => $_POST["txt_caminho_imagem"],
        );
        
        $perguntaAtual->setImagem($imagem);
        $perguntaAtual->setPeso($_POST['txt_peso_pergunta']);
        
        $tags = array();
        //Testa se o Campo Tags está preenchido e salva as tags individualmente
        if($_POST["txt_tags"] != ""){
            $tags = explode(";", $_POST["txt_tags"]); 
        }
        
        array_push($tags, $questionario->getMateria());
        
        $perguntaAtual->setTags($tags);
        
        //Salva objeto "PerguntaAtual" no vetor de perguntas
        $perguntas[$numDaPergunta] = $perguntaAtual;
        //Salva o objeto "Alternativas" no vetor de alternativas
        $perguntas_alternativas[$numDaPergunta] = $alternativas;
        
        //Atualiza variáveis de seção
        $_SESSION["numPerguntas"] = $numDaPergunta;
        $_SESSION["perguntas"] = serialize($perguntas);
        $_SESSION["perguntas_alternativas"] = serialize($perguntas_alternativas);
        $_SESSION["questionario"] = serialize($questionario);
        
        //Redireciona para a página de sumário do questionário
        header('location: sumario_questionario.php');
    }

?>  
<html lang="pt-BR">
    <head>
        <title>Criar Questionário</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>
        <?PHP include 'menu.php'; ?>
        <form id="form_cria_pergunta" class="" method="POST" action="">
            <div class="container" id="criando_questionario">
                <div id="opcao_pergunta"> <!-- Cria pergunta ou seleciona no banco --> 
                    <h4>Selecione uma opção:</h4>
                    <center>
                        <button id="nova_pergunta" type="button" class="btn btn-default">Criar Nova Pergunta</button>
                        <button id="escolher_pergunta" type="button" class="btn btn-default">Escolher Pergunta no Banco</button>
                    </center>    
                </div> <!-- fim: #opcao_pergunta -->

                <div id="pergunta_banco"> <!-- Seleciona pergunta no banco -->
                    <label for="txt_busca">Buscar Perguntas:</label>
                    <div id="div_busca_pergunta" class="input-group">
                        <input type="text" id="txt_busca" class="form-control"/>
                        <select id="slc_opcaoBusca" name="slc_opcaoBusca" class="form-control">
                            <option>Palavra-chave</option>
                            <option>Enunciado</option>
                            <option>Materia</option>
                        </select>
                        <span class="input-group-btn">
                            <button id="btn_buscar" class="btn btn-primary">Buscar</button>
                        </span>
                    </div>

                    <br>

                    <div class="table_header">
                        <!-- As tags estão assim para evitar espaço entre as divs -->
                        <div id="header_enunciado">Enunciado</div
                        ><div id="header_tipo">Tipo</div
                        ><div id="header_peso">Peso</div>
                    </div>

                    <div class="table_body">
                        <div id="body_nenhuma">Nunhuma pergunta encontrada!</div>
                        <table id="tabela_perguntas">

                        </table>
                    </div>

                    <br>

                    <div class="pull-left">
                        <input type="button" id="escolhe_banco_btn_voltar" class="btn btn-danger" value="Voltar"/>
                    </div>

                    <br>
                </div> <!-- fim: #pergunta_banco -->

                <div id="tipo_pergunta"> <!-- Seleciona tipo de pergunta e mostra enunciado -->
                    <div class="container-fluid">
	                   <div class="row">
		                  <div class="col-md-12 col-xs-12">
                                <center>
                                <label for="rb_tipo_pergunta">Tipo da Pergunta:</label>
                                <br>
                                <div id="rb_tipo_pergunta" class="btn-group" data-toggle="buttons">
                                    <label id="lbl_alternativa" class="btn btn-primary active">
                                        <input type="radio" name="tipo_pergunta" value="Alternativa" id="cbx_alternativa" autocomplete="off" checked="checked">Alternativa
                                    </label>
                                    <label id="lbl_trueFalse" class="btn btn-primary">
                                        <input type="radio" name="tipo_pergunta" value="Verdadeiro/Falso" id="cbx_trueFalse" autocomplete="off"><span id="texto_pequeno">Verd. / Falso</span><span id="texto_grande">Verdadeiro ou Falso</span>
                                    </label> 
                                    <label id="lbl_dissertativa" class="btn btn-primary">
                                        <input type="radio" name="tipo_pergunta" value="Dissertativa" id="cbx_dissertativa" autocomplete="off">Dissertativa
                                    </label>
                                </div>
                                </center>
                                <br>                                
		                  </div>
	                   </div>
                        <div id="alerta_dissertativa" class="alert alert-warning" role="alert">
                            <center>Questões dissertativas não são corrigidas automaticamente, <br> 
                                    as mesmas devem ser corrigidas manualmente pelo professor.</center>
                        </div>
                        <div class="row" id="div_enunciado">
                            <div class="col-md-12 col-xs-12">
                                <input type="hidden" id="txtNumPergunta" name="txtNumPergunta" value=3>
                                <label for="txt_enunciado">Enunciado da Pergunta:</label>
                                <textarea id="txt_enunciado" name="txt_enunciado" class="form-control" rows="5" required></textarea>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-4" id="div_img_preview">
                                <img src="resources/images/temp_img.jpg" id="img_preview" alt="Imagem da Pergunta" class="img-thumbnail"></img>
                            </div>
                            <div class="col-md-8" id="div_img_pergunta">
                                <label for="img_pergunta">Inserir Imagem: (Opcional)</label>
                                <div class="input-group">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Browse&hellip; <input type="file" id="img_pergunta" style="display: none;" multiple>
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" id="txt_img_pergunta" readonly>
                                </div>
                                <input type="hidden" id="txt_caminho_imagem" name="txt_caminho_imagem" readonly>
                                <input type="hidden" id="txt_tipo_imagem" name="txt_tipo_imagem"> 
                            </div>
                        </div>                        
                    </div>
                </div> <!-- fim: #tipo_pergunta -->
                <div id="pergunta_alternativas"> <!-- Mostra formulários para perguntas com alternativas -->
                    <div class="container-fluid">
                        <div class="row">        
                            <div class="col-md-12 col-xs-12">
                                <label for="num_alternativas">Número de Alternativas</label>
                                <select id="num_alternativas" name="num_alternativas" class="form-control">
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                </select>
                            </div>                                                       
                        </div>                        
                        <div class="row" id="div_alternativa_1">
                            <div class="col-md-12 col-xs-12">                            
                                <label for="group_alternativa_1">Alternativa 01</label>
                                <div class="input-group" id="group_alternativa-1">
                                    <textarea id="txt_alternativa_1" rows="2" class="form-control" name="txt_alternativa_1" required></textarea>
                                    <div class="input-group-addon">
                                        <input type="radio" name="alt_correta" value="1" id="rb_alternativa_1" checked>
                                        <input type="checkbox" name="chk_alternativa_1" value="true" id="chk_alternativa_1">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="row" id="div_alternativa_2">
                            <div class="col-md-12 col-xs-12">
                                <label for="group_alternativa_2">Alternativa 02</label>
                                <div class="input-group" id="group_alternativa-2">
                                    <textarea id="txt_alternativa_2" rows="2" class="form-control" name="txt_alternativa_2" required></textarea>
                                    <div class="input-group-addon">
                                        <input type="radio" name="alt_correta" value="2" id="rb_alternativa_2">
                                        <input type="checkbox" name="chk_alternativa_2" value="true" id="chk_alternativa_2">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="row" id="div_alternativa_3">
                            <div class="col-md-12 col-xs-12">
                                <label for="group_alternativa_3">Alternativa 03</label>
                                <div class="input-group" id="group_alternativa-3">
                                    <textarea id="txt_alternativa_3" rows="2" class="form-control" name="txt_alternativa_3"></textarea>
                                    <div class="input-group-addon">
                                        <input type="radio" name="alt_correta" value="3" id="rb_alternativa_3">
                                        <input type="checkbox" name="chk_alternativa_3" value="true" id="chk_alternativa_3">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="row" id="div_alternativa_4">
                            <div class="col-md-12 col-xs-12">
                                <label for="group_alternativa_4">Alternativa 04</label>
                                <div class="input-group" id="group_alternativa-4">
                                    <textarea id="txt_alternativa_4" rows="2" class="form-control" name="txt_alternativa_4"></textarea>
                                    <div class="input-group-addon">
                                        <input type="radio" name="alt_correta" value="4" id="rb_alternativa_4">
                                        <input type="checkbox" name="chk_alternativa_4" value="true" id="chk_alternativa_4">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="row" id="div_alternativa_5">
                            <div class="col-md-12 col-xs-12">
                                <label for="group_alternativa_5">Alternativa 05</label>
                                <div class="input-group" id="group_alternativa-5">
                                    <textarea id="txt_alternativa_5" rows="2" class="form-control" name="txt_alternativa_5"></textarea>
                                    <div class="input-group-addon">
                                        <input type="radio" name="alt_correta" value="5" id="rb_alternativa_5">
                                        <input type="checkbox" name="chk_alternativa_5" value="true" id="chk_alternativa_5">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="row" id="div_alternativa_6">
                            <div class="col-md-12 col-xs-12">
                                <label for="group_alternativa_3">Alternativa 06</label>
                                <div class="input-group" id="group_alternativa-6">
                                    <textarea id="txt_alternativa_5" rows="2" class="form-control" name="txt_alternativa_6"></textarea>
                                    <div class="input-group-addon">
                                        <input type="radio" name="alt_correta" value="6" id="rb_alternativa_6">
                                        <input type="checkbox" name="chk_alternativa_6" value="true" id="chk_alternativa_6">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <center>
                                    <label id="lbl_alt_verdadeira">Não se esqueça de marcar as alternativas verdadeiras!</label>
                                    <label id="lbl_alt_correta">Não se esqueça de marcar a alternativa correta!</label>
                                </center>
                            </div>
                        </div>
                    </div>                                                                    
                </div> <!-- fim: #pergunta_alternativas -->
                <div id="div_tags">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="txt_tags">Palavras Chave da Pergunta: (Separe cada uma com ";").</label>
                                <input type="text" name="txt_tags" id="txt_tags" class="form-control" placeholder="Ex: português; verbos; conjugação">
                            </div>
                        </div>                            
                    </div>  
                </div> <!-- fim: #div_tags -->
                <div id="div_botao">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <br>
                                <div class="pull-right">
                                    <input type="button" id="criar_pergunta_btn_voltar" class="btn btn-danger" value="Voltar"/>
                                    &nbsp;	
                                    <button type="submit" class="btn btn-success" id="btn_continuar">Continuar</button>
                                    <br><br>
                                </div>                                
                            </div>        
                        </div>
                    </div>    
                </div>                            
            </div>                                                                                                 
        </form>
    
        <!-- Importa o touch Spinner -->
        <link rel="stylesheet" href="css/jquery.bootstrap-touchspin.min.css">   
        <script type="text/javascript" src="js/jquery.bootstrap-touchspin.min.js"></script> 
        
        <script>
            function validaFormato(arquivo){
                var extensoes, ext, valido;
                extensoes = new Array('.jpg','.png','.gif', '.bmp');
    
                ext = arquivo.substring(arquivo.lastIndexOf(".")).toLowerCase();
                $("#txt_tipo_imagem").val(arquivo.substring(arquivo.lastIndexOf(".") + 1).toLowerCase());
                valido = false;
    
                for(var i = 0; i <= arquivo.length; i++){
                    if(extensoes[i] == ext){
                        valido = true;
                        break;
                    }
                }
     
                if(valido){
                    return true;
                }

                return false;
            }            

            $('#img_pergunta').change(function(){
                var path = $('#img_pergunta').val();
                var parts = path.split('\\');
                var answer = parts[parts.length - 1];
                $("#txt_img_pergunta").val(answer);
            });

            //Executa função para ler imagem do input file
            $("#img_pergunta").change(function(){
               //Testa se o arquivo é uma imagem (chamando a função validaFormato)
               if($("#img_pergunta").val() == ""){
                    $("#img_pergunta").removeClass("inputErro");
                    $("#img_preview").attr("src", "resources/images/temp_img.jpg"); 
               }else{
                    if(validaFormato($("#img_pergunta").val())){
                        if (this.files && this.files[0]) {
                            var file = new FileReader();
                            file.onload = function(e) {
                                //Muda thumbnail para imagem recebida
                                document.getElementById("img_preview").src = e.target.result;
                                $("#txt_caminho_imagem").val(e.target.result);     
                            }                     
                        };                           
                        file.readAsDataURL(this.files[0]);                        
                        $("#img_pergunta, #txt_img_pergunta").removeClass("inputErro");
                    }else{
                        $("#img_pergunta, #txt_img_pergunta").addClass("inputErro");
                        $("#img_preview").attr("src", "resources/images/error_img.jpg");
                    }  
               }
            });
            
            //Script do TouchSpinner
            $("input[name='txt_peso_pergunta']").TouchSpin({
                min: 0,
                max: 100,
                step: 0.5,
                decimals: 1,
                boostat: 5,
                maxboostedstep: 10,
            });
            
            //Habilita as alternativas conforme a mudança de valores no combobox
            $('#num_alternativas').change(function(){
                switch ($('#num_alternativas').val()) {
                    case "2":
                        $("#div_alternativa_3").hide();
                        $("#div_alternativa_4").hide();
                        $("#div_alternativa_5").hide();
                        $("#div_alternativa_6").hide();
                        break;
                    case "3":
                        $("#div_alternativa_3").show();
                        $("#div_alternativa_4").hide();
                        $("#div_alternativa_5").hide();
                        $("#div_alternativa_6").hide();
                        break;
                    case "4":
                        $("#div_alternativa_3").show();
                        $("#div_alternativa_4").show();
                        $("#div_alternativa_5").hide();
                        $("#div_alternativa_6").hide();
                        break;
                    case "5":
                        $("#div_alternativa_3").show();
                        $("#div_alternativa_4").show();
                        $("#div_alternativa_5").show();
                        $("#div_alternativa_6").hide();
                        break;
                    case "6":    
                        $("#div_alternativa_3").show();
                        $("#div_alternativa_4").show();
                        $("#div_alternativa_5").show();
                        $("#div_alternativa_6").show();
                        break;  
                }            
            });
            
            //Ativa e Desativa Campo de Peso de Pergunta
            $("#chk_peso_pergunta").change(function(){              
                if($(this).is(':checked')){
                    $("#txt_peso_pergunta").prop("disabled", false);
                }else{
                    $("#txt_peso_pergunta").prop("disabled", true);
                }
            });
                             
            //Muda o Link Ativo no Menu lateral
                $("#criar_questionario").addClass("active");
                $("#opcoes_questionario").collapse("show");
                $("#teste").addClass("active");  
                $("#home").removeClass("active");

            //Mostra formulários para criar nova pergunta
            $("#nova_pergunta").click(function(){
                $("#tipo_pergunta").show();
                $("#div_botao").show();
                $("#pergunta_alternativas").show();
                $("#opcao_pergunta").hide(); 
                $("#div_tags").show();                
            });

            $("#criar_pergunta_btn_voltar").click(function(){
                $("#tipo_pergunta").hide();
                $("#div_botao").hide();
                $("#pergunta_alternativas").hide();
                $("#opcao_pergunta").show(); 
                $("#div_tags").hide();  
                $("#form_cria_pergunta")[0].reset();
                $("#num_alternativas").change();
            });

            $("#escolher_pergunta").click(function(){
                $("#opcao_pergunta").hide();
                $("#pergunta_banco").show();
            });

            $("#escolhe_banco_btn_voltar").click(function(){
                $("#pergunta_banco").hide();
                $("#opcao_pergunta").show();
                $("#form_cria_pergunta")[0].reset();
                $("#num_alternativas").change();
            });

            $("#cbx_alternativa, #lbl_alternativa").click(function(){
                //Mostra as alternativas
                $("#pergunta_alternativas").show();
                $("#lbl_alt_verdadeira").hide();
                $("#lbl_alt_correta").show();
                $("#txt_alternativa_1").prop("disabled", false);
                $("#txt_alternativa_2").prop("disabled", false);
                $("#num_alternativas").prop("disabled", false);

                //Mostra os Radio Buttons
                $("#rb_alternativa_1").show();
                $("#rb_alternativa_2").show();
                $("#rb_alternativa_3").show();
                $("#rb_alternativa_4").show();
                $("#rb_alternativa_5").show();
                $("#rb_alternativa_6").show();
                
                //Esconde os Checkboxs de verdadeiro ou falso
                $("#chk_alternativa_1").hide();
                $("#chk_alternativa_2").hide();
                $("#chk_alternativa_3").hide();
                $("#chk_alternativa_4").hide();
                $("#chk_alternativa_5").hide();
                $("#chk_alternativa_6").hide();

                $("#alerta_dissertativa").hide();
            });

            $("#cbx_dissertativa, #lbl_dissertativa").click(function(){
                $("#pergunta_alternativas").hide();
                $("#txt_alternativa_1").prop("disabled", true);
                $("#txt_alternativa_2").prop("disabled", true);
                $("#num_alternativas").prop("disabled", true);
                $("#alerta_dissertativa").fadeIn();
            });

            $("#cbx_trueFalse, #lbl_trueFalse").click(function(){
                //Mostra as alternativas
                $("#pergunta_alternativas").show();
                $("#lbl_alt_verdadeira").show();
                $("#lbl_alt_correta").hide();
                $("#txt_alternativa_1").prop("disabled", false);
                $("#txt_alternativa_2").prop("disabled", false);
                $("#num_alternativas").prop("disabled", false);
                
                //Esconde os Radio Buttons
                $("#rb_alternativa_1").hide();
                $("#rb_alternativa_2").hide();
                $("#rb_alternativa_3").hide();
                $("#rb_alternativa_4").hide();
                $("#rb_alternativa_5").hide();
                $("#rb_alternativa_6").hide();
                
                //Mostra os Checkboxs de verdadeiro ou falso
                $("#chk_alternativa_1").show();
                $("#chk_alternativa_2").show();
                $("#chk_alternativa_3").show();
                $("#chk_alternativa_4").show();
                $("#chk_alternativa_5").show();
                $("#chk_alternativa_6").show();

                $("#alerta_dissertativa").hide();
            });

            $("#btn_buscar").click(function(){

                var txtBusca = $("#txt_busca").val();
                var slc_opcaoBusca = $("#slc_opcaoBusca").val();

                var dataString = "txt_busca="+txtBusca+"&slc_opcaoBusca="+slc_opcaoBusca;
                //Popula a tabela com as perguntas encontradas no banco
                $.ajax({
                    type: "POST",
                    url: "scripts/tabela.php",
                    data: dataString,
                    dataType: "json",
                    success: function(data){
                    
                        if(data == 0){
                            $("#body_nenhuma").show();
                            $("#tabela_perguntas").html("");
                        }else{
                            var linhas = "";

                            data.forEach(function(item){
                                linhas += "<tr>";
                                linhas += "<td id='body_enunciado'>" + item["enunciado"] + "</td>";
                                linhas += "<td id='body_tipo'>" + item["tipo"] + "</td>";
                                linhas += "<td id='body_peso'>" + item["peso"] + "</td>";
                                linhas += "<td id='body_codigo'>" + item["codigo"] + "</td>";
                                linhas += "<tr>"; 
                            });

                            $("#body_nenhuma").hide();
                            $("#tabela_perguntas").html(linhas);
                        }
                    }
                });
            });

            //Função executada quando clica em alguma pergunta na tabela
            $(".table_body table").delegate('tr', 'click', function(){
                var dataString = "perg_codigo="+$(this).find("td:nth-child(4)").html();

                $.ajax({
                    type: "POST",
                    url: "scripts/consulta_pergunta.php",
                    data: dataString,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            //Aplica as informações coletadas no banco na página de criação de pergunta
                            switch(data[0]){
                                case "A":
                                    $("#lbl_alternativa").click();
                                    break;

                                case "V":
                                    $("#lbl_trueFalse").click();
                                    break;

                                case "D":
                                   $("#lbl_dissertativa").click();
                                    break;
                            }

                            $("#txt_enunciado").val(data[2]);
                            
                            tags = data[5];

                            for(var i = 0; i < tags.length; i++){
                                $("#txt_tags").val($("#txt_tags").val() + tags[i] + ";");
                            }

                            
                            if (data[3] != ""){
                                $("#img_preview").prop("src", data[3]);
                            }else{
                                $("#img_preview").prop("src", "resources/images/temp_img.jpg");
                            }
                            

                            $("#txt_caminho_imagem").val(data[3]);
                            var parts = data[3].split('/');
                            var answer = parts[parts.length - 1];
                            $("#txt_img_pergunta").val(answer);


                            //Se o tipo não for Dissertativa
                            if(data[0] != "D"){
                                var alternativas = data[7];
                                
                                $("#num_alternativas").val(data[6]);
                                $("#num_alternativas").change();


                                for(var i = 1; i <= data[6]; i++){
                                    $("#txt_alternativa_"+i).val(alternativas[i-1]["alternativa_texto"]);
                                    if(alternativas[i-1]["alternativa_correta"] == 1){
                                        $("#rb_alternativa_"+i).prop("checked", true);
                                        $("#chk_alternativa_"+i).prop("checked", true);
                                    }

                                }   

                                $("#pergunta_alternativas").show();
                            }

                            $("#pergunta_banco").hide();
                            $("#tipo_pergunta").show();
                            $("#div_botao").show();                            
                            $("#opcao_pergunta").hide(); 
                            $("#div_tags").show();  
                        }
                    }
                });
            });
        </script>
    </body>                     
</html>    