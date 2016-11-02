<?php

if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header('location: cadastro.php');
}

include "classes/conexao.class.php";
include "classes/instituicao.class.php";

$nome = $_POST['txt_nome_instituicao'];
$email = $_POST['txt_email'];
$senha = $_POST['txt_senha1'];
$senha2 = $_POST['txt_senha2'];
$documento_tipo = $_POST['slt_documento'];
$numero_documento = $_POST['txt_documento'];
$telefone = $_POST['txt_telefone'];
$logradouro = $_POST['txt_logradouro'];
$numero = $_POST['txt_numero'];
$bairro = $_POST['txt_bairro'];
$cep = $_POST['txt_cep'];
$cidade = $_POST['txt_cidade'];
$uf = $_POST['txt_uf'];
$pais = $_POST['txt_pais'];
$msg1 = "Nenhum Campo em Branco";
$msg2 = "";

$conexao = new Conexao();

$query = ("SELECT user_email FROM usuarios WHERE user_email = '{$email}';");
$resultado = $conexao->executaComando($query) or die("Erro ao checar email.");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){           //Se não recebeu dados, não insere no banco
        if(trim($nome) == "" || trim($email) == "" || trim($senha) == "" || trim($documento_tipo) == "" || trim($numero_documento) == "" || trim($telefone) == "" || trim($logradouro) == "" || trim($numero) == "" || trim($bairro) == "" || trim($cep) == "" || trim($uf) == "" || trim($pais) == ""){
            echo "Nenhum dado recebido!";
        }else{
            if(mysqli_num_rows($resultado) == 0){ //Verifica se o email informado já está cadastrado
                if($senha == $senha2){
                    $inst = new Instituicao($nome, $logradouro, $numero, $cep, $bairro, $cidade, $uf, $pais, $telefone, $email, $senha, $documento_tipo, $numero_documento);
                        if($inst->insertInst()){
                            echo "cadastrado com sucesso";
                        }
                }else{
                    echo "As senhas não coincidem!<br>";
                }
            }else{
                echo "Email da Instituicao em uso, tente novamente!";
            }
        }
    }
    unset($_POST);
?>