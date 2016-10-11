<?PHP
    // Inicia a Sessão
	session_start();

    if( $_SERVER['REQUEST_METHOD'] == 'POST'){
        
        require_once '../classes/conexao.class.php';
        
        $conexao = new Conexao();
        
        $resultado = $conexao->executaComando('SELECT user_email, user_nome, user_tipo FROM usuarios WHERE user_email="'.$_POST['email'].'" AND user_senha="'.$_POST['senha'].'";');
        
        if(mysqli_num_rows($resultado) == 1){ //Conta número de linhas que foram retornadas do banco
            $usuario = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
            $_SESSION['user_email'] = $usuario['user_email'];
            $_SESSION['user_tipo'] = $usuario['user_tipo'];            

            if($usuario['user_tipo'] == 'A' || $usuario['user_tipo'] == 'P'){
                switch ($usuario['user_tipo']){
                    case "A":
                        $tipo = "aluno";
                        $tabela = "alunos";
                        break;
                    case "P":
                        $tipo = "professor";
                        $tabela = "professores";
                        break;
                }

                $resultado = $conexao->executaComando("SELECT ".$tipo."_sobrenome, ".$tipo."_instituicao FROM ".$tabela." WHERE ".$tipo."_email='".$usuario["user_email"]."';");
                $linha = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
    
                $_SESSION['user_instituicao'] = $linha[$tipo.'_instituicao'];
                $_SESSION['user_nome'] = $usuario['user_nome']." ".$linha[$tipo.'_sobrenome'];
            }else{
                $resultado2 = $conexao->executaComando('SELECT inst_codigo FROM instituicoes WHERE inst_email="'.$_POST['email'].'";');
                $linha2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC);
                $_SESSION['inst_codigo'] = $linha2['inst_codigo'];
                $_SESSION['user_nome'] = $usuario['user_nome'];
            }

            echo $_SESSION['user_email'];
        }
    }
?>