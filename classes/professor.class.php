<!--
DATA: 25/10/16    
ARQUIVO: professor.class.php
DESCRIÇÃO: Classe modelo - Professor
-->     

<?PHP
	class Professor{
		//Atributos
		private $email;
        private $senha;
        private $nome;
        private $sobrenome;
        private $rg;
        private $cpf;
        private $instituicao;

		
		//Construtor com parâmetros
		public function __construct($email, $senha, $nome, $sobrenome, $rg, $cpf, $instituicao){
			$this->email = $email;
			$this->senha = $senha;
			$this->nome = $nome;
			$this->sobrenome = $sobrenome;
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
		//Função para Inserir Professores no Banco de Dados
        public function insertProfessor(){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
			$query1 = "INSERT INTO usuarios VALUES ('{$this->email}', '{$this->senha}', '{$this->nome}', 'A');";
			$query2 = "INSERT INTO professores (professor_email, professor_sobrenome, professor_rg, professor_cpf, professor_instituicao) VALUES ('{$this->email}', '{$this->sobrenome}', '{$this->rg}', '{$this->cpf}', '{$this->instituicao}');";
			return ($conexao->executaComandos($query1.$query2));
        }
        
        //Função para Deletar Professores no Banco de Dados
        public function deleteProfessores($professor_email){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
			$query1 = "DELETE FROM aluno_turma WHERE professor_email='{$email}';";
			$query2 = "DELETE FROM usuarios WHERE user_email='{$email}';"; 
			$query3 = "DELETE FROM alunos WHERE professor_email='{$email}';";
            $conexao->executaComandos($query1.$query2.$query3);
        }
        
        //Função para Consultar Professores no Banco de Dados
        public function consultaProfessor($email){
            require_once 'conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM professores WHERE inst_codigo='{$email}'");
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