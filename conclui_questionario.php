<!--
DATA: 03/05/16    
ARQUIVO: home.php
DESCRIÇÃO: Página de início, primeira página após o login
-->

<!DOCTYPE html>
<?php
	//Imports
    require_once "classes/materia.class.php";
    require_once "classes/questionario.class.php";
    require_once "classes/pergunta.class.php";
    require_once "classes/pergunta_alternativa.class.php";

     // Inicia a Sessão
	session_start();

	if($_SESSION["user_tipo"] != "P"){
        header('location: permission_denied.php'); 
    }

    //Verifica se usuário está logado, caso contrário vai para o login
    if(!isset($_SESSION['user_nome']) && empty($_SESSION['user_nome'])) {
        header('location: logout.php');
    }
    
    if(isset($_SESSION["questionario"])){
        
        //Instancia Objetos
        $materia = new Materia();
        
        //Recebe objetos já existentes da seção
        $questionario = unserialize($_SESSION["questionario"]);
        $perguntas = unserialize($_SESSION["perguntas"]);
        $perguntas_alternativas = unserialize($_SESSION["perguntas_alternativas"]);    

        /*
        Busca se a matéria que está no objeto questionário já existe no banco,
        se já, retorna o código dela e salva no objeto questionário, senão à
        cadastra e salva o codigo no objeto questionario.
        */
        $codMateria = $materia->consultaNomeMateria($questionario->getMateria());
        if(mysqli_num_rows($codMateria) == 1){
            $resultado = mysqli_fetch_array($codMateria);
            $questionario->setMateria($resultado["materia_codigo"]);
        }else{
            $materia->setNome($questionario->getMateria());
            $questionario->setMateria($materia->insertMateria());
        }

        //Salva o número de perguntas no objeto Questionário
        $questionario->setNumPerguntas($_SESSION["numPerguntas"]);

        //Testa se existem perguntas dissertativas no questionário
        if($questionario->getNecessitaCorrecao() == ""){
            $questionario->setNecessitaCorrecao(0);
        }

        //Testa se foi setado tempo para resposta do questionário
        if($questionario->getTempo() == ""){
            $questionario->setTempo(0);
        }    

        //Salva o questionário no banco e retorna o ID do mesmo para a variável $quest_codigo
        $quest_codigo = $questionario->insertQuest();

        for($i = 1; $i <= $_SESSION["numPerguntas"]; $i++){
            //Retorna vetor com imagem da pergunta
            $imagem = $perguntas[$i]->getImagem();

            /*
            Verifica se o vetor $imagem está vazio (se tem imagem na pergunta)
            faz upload da imagem para o servidor e atualiza caminho no objeto pergunta 
            */
            if($imagem["tmp_name"] != ""){
                $caminho_imagem = $perguntas[$i]->redimensionar($imagem, 600, "resources/imagens_perguntas/".$_SESSION["user_instituicao"]);
                $perguntas[$i]->setImagem($caminho_imagem);
            }else{
                $perguntas[$i]->setImagem("");
            }

            //Insere a pergunta no banco
            $codPergunta = $perguntas[$i]->insertPergunta();
            //Atribui o código da pergunta que foi inserida no objeto pergunta
            $perguntas[$i]->setCodigo($codPergunta);

            //Verifica se a pergunta é de alternativas, caso seja, salva as mesmas no banco
            if($perguntas[$i]->getTipo() != "Dissertativa"){
                for($j = 1; $j <= $perguntas[$i]->getNumAlternativas(); $j++){
                $alternativaAtual = $perguntas_alternativas[$i]->getAlternativa($j);
                $alternativaAtual["perg_codigo"] = $codPergunta;
                $perguntas_alternativas[$i]->insertAlternativa($alternativaAtual);
                }
            }

            $perguntas[$i]->salvaTags();

            //Atribui pergunta ao questionário
            $perguntas[$i]->atribuiQuestionario($quest_codigo);    

        }

        //Limpa variáveis de ambiente
        unset($_SESSION["questionario"], $_SESSION["numPerguntas"], $_SESSION["perguntas"], $_SESSION["perguntas_alternativas"]);
        
    }    

?>

<html lang="pt-BR">
    <head>
        <title>Questionário Finalizado</title>
        <?PHP include 'imports.html'; ?>
    </head>
    <body>        
        <?PHP include 'menu.php'; ?>
        
        <div class="container"> <!-- Onde vai ficar o conteúdo da página --> 
			<div class="container-fluid" id="opcao_pergunta">
                <div class="row">
                    <div class="col-md-3">
                        <img src="resources/images/concluindo.png">
                    </div>
                    <div class="col-md-9">
                        <br><br>
                        <center><b>Questionário salvo com sucesso!</b></center>
                    </div>
                </div>
			</div>
            <div class="container-fluid">
                <div class="pull-right">
                    <br>
                    <input type="button" id="btn_meus_questionarios" class="btn btn-primary" value= "Meus Questionários"/>
                    <input type="button" id="btn_novo_questionario" class="btn btn-success" value= "Criar Novo Questionário"/>
                </div>
            </div>
        </div> <!-- Fim do Conteúdo da página -->
        
        <script> 
            $("#btn_meus_questionarios").click(function(){
                window.location.href = "meus_questionarios.php";
            });

            $("#btn_novo_questionario").click(function(){
                window.location.href = "criar_questionario.php";
            });

            $("#home").addClass("active");
            $("#criar_questionario").removeClass("active");                   
        </script>        
    </body>
</html>    