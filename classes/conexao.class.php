<?PHP
    # Informa qual o conjunto de caracteres será usado.
    header('Content-Type: text/html; charset=utf-8');
    
    class Conexao{
        //Atributos
        private $bd_endereco = "127.0.0.1"; //Endereço do Servidor MySQL
        private $bd_user = "root"; //Usuário do Servidor MySQL
        private $bd_senha = ""; //Senha do Servidor MySQL
        private $bd_banco ="frage"; //Nome do BD
        private $error_message = 'Não foi possível se conectar com o Banco de Dados';
        private $conexao;
        
        //Abre conexão e executa comando no banco de dados
        public function executaComando($comando){
            $conexao = mysqli_connect($this->bd_endereco, $this->bd_user, $this->bd_senha, $this->bd_banco) or die($this->error_message);
            mysqli_set_charset($conexao, "utf8");
            return mysqli_query($conexao, $comando);
        }

        //Abre conexão e executa comandos concatenados
        public function executaComandos($comandos){
            $conexao = mysqli_connect($this->bd_endereco, $this->bd_user, $this->bd_senha, $this->bd_banco) or die($this->error_message);
            mysqli_set_charset($conexao, "utf8");
            return mysqli_multi_query($conexao, $comandos);
        }

        //Insere e retorna lastId()
        public function retornaId($comando){
            $conexao = mysqli_connect($this->bd_endereco, $this->bd_user, $this->bd_senha, $this->bd_banco) or die($this->error_message);
            mysqli_set_charset($conexao, "utf8");
            mysqli_query($conexao, $comando);
            return mysqli_insert_id($conexao);
        }
    }
?>