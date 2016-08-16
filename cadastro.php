<!DOCTYPE html>

<html lang="pt-BR">
    <head>
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
        <script type="text/javascript" src="js/jquery.validate.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default"> <!-- Começo da Barra de Navegação -->
            <div class="container-fluid">
                <form action="index.php" class="navbar-header pull-right">                
                    <button type="submit" id="btn_login" class="btn btn-success pull-left" href="index.php">Login</button>
                </form>
            </div>
        </nav>
        
        <div class="container">
            <div class="wrapper">
                <form class="form-signin" id="form_login" method="POST" action="cadastrando.php">
                    <div id="txtLogin" class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <center><h2 class="form-signin-heading">Cadastrar Instituição</h2></center>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label for="txt_nome_instituicao" class="label-form-cadastro">Nome da Instituição:</label>
                                <input type="text" name="txt_nome_instituicao" id="txt_nome_instituicao" class="form-control" required autofocus>
                            </div>
                        </div>
                        
                        <div class="row" id="div_email">  
                            <div class="col-md-12">
                                <a href="#" id="email"></a>
                                <label class="label-form-cadastro">Email da Instituição:</label>
                                <input type="email" name="txt_email" id="txt_email" class="form-control" required>
                                <label id="email_uso" class="sr-only control-label">Email em uso!</label>
                                <label id="email_valido" class="sr-only control-label">Email disponível</label>
                                <label id="email_invalido" class="sr-only control-label">Email inválido</label>
                            </div>
                        </div> 
                        
                        <div class="row" id="div_senha">
                            <div class="col-md-6">
                                <a href="#" id="senha"></a>
                                <div id="senha-esquerda">
                                    <label class="label-form-cadastro">Senha:</label>
                                    <input type="password" id="txt_senha1" name="txt_senha1" class="form-control" required>
                                    <label class="control-label" id="erro_senha">As senhas não coincidem!</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="senha-direita">
                                    <label class="label-form-cadastro">Confirmar Senha:</label>
                                    <input type="password" id="txt_senha2" name="txt_senha2" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row"> 
                            <div class="col-md-12">
                                <label class="label-form-cadastro">CPF/CNPJ:</label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <select name="slt_documento" id="slt_documento" class="btn btn-default">
                                            <option value="CNPJ">CNPJ</option>
                                            <option value="CPF">CPF</option>
                                        </select>
                                    </span>  
                                    <input type="text" id="txt_documento" name="txt_documento" class="form-control" placeholder="__.___.___/____-__" required>
                                </div><!-- /input-group -->
                            </div>	
                        </div>
                        
                        <div class="row">    
                            <div class="col-md-12">
                                <label class="label-form-cadastro">Telefone:</label>
                                <input type="text" name="txt_telefone" id="txt_telefone" class="form-control" maxlength="15" required> 
                            </div>
                        </div> 
                            
                            <hr id="linha"></hr>
                            
                                        
                        <div class="row">
                            <div class="col-md-9">
                                <label class="label-form-cadastro">Logradouro:</label>
                                <input type="text" name="txt_logradouro" id="txt_logradouro" class="form-control" required>                                                
                            </div>
                            <div class="col-md-3">
                                <label class="label-form-cadastro">Número:</label>
                                <input type="text" name="txt_numero" id="txt_numero" class="form-control" required>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <div class="col-md-8">
                                <label class="label-form-cadastro">Bairro:</label>
                                <input type="text" name="txt_bairro" id="txt_bairro" class="form-control" required>                                                
                            </div>
                            <div class="col-md-4">
                                <label class="label-form-cadastro">CEP:</label>
                                <input type="text" name="txt_cep" id="txt_cep" class="form-control" required>
                            </div>
                        </div> 
                        
                        <div class="row">
                            <div class="col-md-9">
                                <label class="label-form-cadastro">Cidade:</label>
                                <input type="text" name="txt_cidade" id="txt_cidade" class="form-control" required>                                                
                            </div>
                            <div class="col-md-3">
                                <label class="label-form-cadastro">UF:</label>
                                <select class="form-control" name="txt_uf" id="txt_uf" required>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AM">AM</option>
                                    <option value="AP">AP</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MG">MG</option>
                                    <option value="MS">MS</option>
                                    <option value="MT">MT</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="PR">PR</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RP">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="RS">RS</option>
                                    <option value="SC">SC</option>
                                    <option value="SE">SE</option>
                                    <option value="SP">SP</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </div>   
                        
                        <div class="row">  
                            <div class="col-md-12">
                                <label class="label-form-cadastro">País:</label>
                                <input type="text" name="txt_pais" id="txt_pais" class="form-control" required>
                            </div>
                        </div>                                           
                        
                        <div class="row">
                            <div class="col-md-12">
                                <button id="btn_cadastro" class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar</button>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>    
        </div> <!-- /container -->
         
    <script> 

    function verifica_senha(){
        if($('#txt_senha1').val() != $('#txt_senha2').val()){
                $('#div_senha').addClass('has-error');
                $('#erro_senha').show();
                return false;
            }else{
                $('#div_senha').removeClass('has-error');
                $('#erro_senha').hide();
                return true;
            }
    }

    $('#txt_senha1').on('input', function(){
        verifica_senha();
    });

    $('#txt_senha2').on('input', function(){
        verifica_senha();
    });

    var email_ok = false;

    $('#form_login').submit(function(){
        if($('#txt_nome_instituicao').val() == "" 
        || $('#txt_email').val() == "" || 
        email_ok == false
        || $('#txt_senha1').val() == "" 
        || $('#txt_senha2').val() == "" 
        || $('#txt_documento').val() == "" 
        || $('#txt_telefone').val() == "" 
        || $('#txt_logradouro').val() == "" 
        || $('#txt_numero').val() == "" 
        || $('#txt_bairro').val() == "" 
        || $('#txt_cep').val() == "" 
        || $('#txt_cidade').val() == "" 
        || $('#txt_pais').val() == ""){
            if($('#txt_email').val() == "" || email_ok == false){
                $('html,body').animate({scrollTop:$('#email').offset().top},'fast');
            }
            return false;
        }else if(verifica_senha() == false){
            $('html,body').animate({scrollTop:$('#senha').offset().top},'fast');
            return false;
        }else{
            return true;
        }
    });

    $('#txt_email').on('input', function(){
        var x = $('#txt_email').val();
        var atpos = x.indexOf("@");
        var dotpos = x.lastIndexOf(".");

        if(x.length > 0){
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length){     //Não é um email
                $('#email_uso').addClass('sr-only');
                $('#email_valido').addClass('sr-only');
                $('#email_invalido').removeClass('sr-only');
                $('#div_email').addClass('has-error');
                email_ok = false;
            }else{                                          //É um email
                var dataString = "txt_email="+$("#txt_email").val();

                $.ajax({
                    type: "POST",
                    url: "chk_email.php",
                    data: dataString,
                    dataType: "json",
                    success:function(data){
                        if(data == 0){                      //Email válido
                            $('#email_uso').addClass('sr-only');
                            $('#email_valido').removeClass('sr-only');
                            $('#div_email').addClass('has-success');
                            $('#div_email').removeClass('has-error');
                            $('#email_invalido').addClass('sr-only');
                            email_ok = true;
                        }else{
                            $('#email_uso').removeClass('sr-only');
                            $('#email_valido').addClass('sr-only');
                            $('#div_email').addClass('has-error');
                            $('#div_email').removeClass('has-success');
                            $('#email_invalido').addClass('sr-only');
                            email_ok = false;
                        }
                    }
                });
            }
        }else{ 
            $('#email_uso').addClass('sr-only');
            $('#email_valido').addClass('sr-only');
            $('#email_invalido').addClass('sr-only');
            $('#div_email').removeClass('has-success');
            $('#div_email').removeClass('has-error');
        }
    });

    $(document).ready(function(){
        $('#txt_telefone').mask("(99) 99999999?9");
    });

    $(document).ready(function(){                           
        //Seta a mascara padrão do campo documento como CNPJ
        $("#txt_documento").mask("99.999.999/9999-99");
        
        //Altera a marcara e o placeholder do campo conforme o valor escolhido no select
        $("#slt_documento").change(function(){
            if($("#slt_documento").val() == "CNPJ"){
                $("#txt_documento").mask("99.999.999/9999-99");
                $("#txt_documento").attr("placeholder", "__.___.___/____-__");
            }else{
                $("#txt_documento").mask("999.999.999-99");
                $("#txt_documento").attr("placeholder", "___.___.___-__");
            }
        });
        
    });
    </script>

    </body>
</html>