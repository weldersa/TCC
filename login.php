<?PHP
    // Inicia a Sessão
	session_start();

    if( $_SERVER['REQUEST_METHOD'] == 'POST'){
        
        require_once 'classes/conexao.class.php';
        
        $conexao = new Conexao();
        
        $resultado = $conexao->executaComando('SELECT * FROM usuarios WHERE user_email="'.$_POST['email'].'" AND user_senha="'.$_POST['senha'].'";');
        
        if(mysqli_num_rows($resultado) == 1){ //Conta número de linhas que foram retornadas do banco
            $usuario = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
            $_SESSION['user_email'] = $usuario['user_email'];
            $_SESSION['user_nome'] = $usuario['user_nome'];
            $_SESSION['user_sobrenome'] = $usuario['user_sobrenome'];
            $_SESSION['user_tipo'] = $usuario['user_tipo'];
            $_SESSION['user_instituicao'] = $usuario['user_instituicao'];
            echo $_SESSION['user_email'];
        }
    }
?>