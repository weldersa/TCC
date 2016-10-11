<?php
//Inicia a sessão
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST"){
    header('location: ../cadastro_aluno.php');
}

include "../classes/conexao.class.php";
include "../classes/aluno.class.php";

echo "<br>". $nome = $_POST['txt_aluno_nome'];
echo "<br>". $sobrenome = $_POST['txt_aluno_sobrenome'];
echo "<br>". $turma = $_POST['slc_turma_aluno'];
echo "<br>". $email = $_POST['txt_email'];
echo "<br>". $senha1 = $_POST['txt_senha1'];
echo "<br>". $senha2 = $_POST['txt_senha2'];
echo "<br>". $cpf = $_POST['txt_aluno_cpf'];
echo "<br>". $rg = $_POST['txt_aluno_rg'];
echo "<br>". $ra = $_POST['txt_aluno_ra'];

$instituicao = $_SESSION['inst_codigo'];

$conexao = new Conexao();

$query = ("SELECT user_email FROM usuarios WHERE user_email = '{$email}';");
$resultado = $conexao->executaComando($query) or die("Erro ao checar email.");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){           //Se não recebeu dados, não insere no banco    
        if(trim($nome) == "" || trim($sobrenome) == "" || trim($turma) == "" || trim($email) == "" || trim($senha1) == "" || trim($senha2) == "" || trim($cpf) == "" || trim($rg) == "" || trim($ra) == ""){
            echo "Nenhum dado recebido!";
        }else{
            if(mysqli_num_rows($resultado) == 0){
                if($senha1 == $senha2){
                    if(strlen($senha1) >= 8){
                        $aluno = new Aluno($email, $senha1, $nome, $sobrenome, $ra, $rg, $cpf, $instituicao);
                            if($aluno->insertAluno()){
                                $_SESSION['msg_cadastro'] = "Aluno Cadastrado com Sucesso!";
                               // header('location: ../cadastro_aluno_msg.php');
                            }else{
                                $_SESSION['msg_cadastro'] = "Ocorreu um erro ao cadastrar o aluno!";
                               // header('location: ../cadastro_aluno_msg.php');
                            }
                    }else{
                        $_SESSION['msg_cadastro'] = "A senha deve ser maior que 8 caracteres!";
                        //header('location: ../cadastro_aluno_msg.php');
                    }
                }else{
                    $_SESSION['msg_cadastro'] = "As senhas não coincidem!";
                   // header('location: ../cadastro_aluno_msg.php');
                }
            }else{
                $_SESSION['msg_cadastro'] = "Email do aluno em uso, tente novamente!";
               // header('location: ../cadastro_aluno_msg.php');
            }
        }
    }
    unset($_POST);

?>