<!--
DATA: 12/09/16    
ARQUIVO: aluno.class.php
DESCRIÇÃO: Classe modelo - Aluno
-->     

<?PHP
	class Aluno{
		//Atributos
		private $email;
        private $senha;
        private $nome;
        private $sobrenome;
        private $ra;
        private $rg;
        private $cpf;
        private $instituicao;

		
		//Construtor com parâmetros
		public function __construct($email, $senha, $nome, $sobrenome, $ra, $rg, $cpf, $instituicao){
			$this->email = $email;
			$this->senha = $senha;
			$this->nome = $nome;
			$this->sobrenome = $sobrenome;
            $this->ra = $ra;
            $this->rg = $rg;
            $this->cpf = $cpf;
            $this->instituicao = $instituicao;
		}
		
		//Getters
		public function getEmail(){
			return $this->email;
		}
        public function getSenha(){
			return $this->senha;
		}
        public function getNome(){
			return $this->nome;
		}
        public function getSobrenome(){
			return $this->sobrenome;
		}
        public function getRa(){
			return $this->ra;
		}
        public function getRg(){
			return $this->rg;
		}
        public function getCpf(){
			return $this->cpf;
		}
        public function getInstituicao(){
			return $this->instituicao;
		}
		
		
		//Setters
		public function setEmail($email){
			$this->email = $email;
		}
        public function setSenha($senha){
			$this->senha = $senha;
		}
        public function setNome($nome){
			$this->nome = $nome;
		}
        public function setSobrenome($sobrenome){
			$this->sobrenome = $sobrenome;
		}
        public function setRa($ra){
			$this->ra = $ra;
		}
        public function setRg($rg){
			$this->rg = $rg;
		}
        public function setCpf($cpf){
			$this->cpf = $cpf;
		}
        public function setInstituicao($instituicao){
			$this->instituicao = $instituicao;
		}

		//Métodos
		//Função para Inserir Alunos no Banco de Dados
        public function insertAluno(){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
			$query1 = "INSERT INTO usuarios VALUES ('{$this->email}', '{$this->senha}', '{$this->nome}', 'A');";
			$query2 = "INSERT INTO alunos (aluno_email, aluno_sobrenome, aluno_ra, aluno_rg, aluno_cpf, aluno_instituicao) VALUES ('{$this->email}', '{$this->sobrenome}', '{$this->ra}', '{$this->rg}', '{$this->cpf}', '{$this->instituicao}');";
			$conexao->executaComandos($query1.$query2);
        }
        
        //Função para Deletar Alunos no Banco de Dados
        public function deleteAluno($aluno_email){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
			$query1 = "DELETE FROM aluno_turma WHERE aluno_email='{$email}';";
			$query2 = "DELETE FROM usuarios WHERE user_email='{$email}';"; 
			$query3 = "DELETE FROM alunos WHERE aluno_email='{$email}';";
            $conexao->executaComandos($query1.$query2.$query3);
        }
        
        //Função para Consultar Alunos no Banco de Dados
        public function consultaAluno($email){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM alunos WHERE inst_codigo='{$email}'");
        }
        
		//--------------------------------------------------------------Corrigir abaixo------------------------------------------------
        //Função para Alterar Instituição no Banco de Dados
        public function alteraAluno($email, $senha, $nome, $sobrenome, $ra, $rg, $cidade, $estado, $pais, $telefone, $email, $senha, $documento_tipo, $numero_documento){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("UPDATE instituicoes SET inst_nome='".$nome."', inst_end_rua='".$rua."', inst_end_numero='".$numero."',
                inst_cep='".$cep."', inst_bairro='".$bairro."', inst_cidade='".$cidade."', inst_estado='".$estado."', inst_pais='".inst_pais."',inst_telefone='".$telefone."', inst_senha='".$senha."', inst_doc_tipo='".$documento_tipo."','".$numero_documento."' WHERE inst_codigo=".$codigo.";");
        }
		
	}
?>