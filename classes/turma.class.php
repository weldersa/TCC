<!--
DATA: 03/05/16    
ARQUIVO: turma.class.php
DESCRIÇÃO: Classe modelo - Turma
-->

<?PHP
	class Turma{
		//Atributos
		private $codigo;
		private $nome;
		private $instituicao;
		
		//Construtor
		public function __construct($nome, $instituicao){
			$this->nome = $nome;
			$this->instituicao = $instituicao;
		}
		
		//Getters
		public function getCodigo(){
			return $this->codigo;
		}
		public function getNome(){
			return $this->nome;
		}
		public function getInstituicao(){
			return $this->instituicao;
		}
		
		//Setters
		public function setNome($nome){
			$this->nome = $nome;
		}
		public function setInstituicao($instituicao){
			$this->instituicao = $instituicao;
		}
		
		//Metodos
		
		//Função para Inserir Turmas no Banco de Dados
        public function insertTurma(){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("INSERT INTO turmas (turma_nome, turma_instituicao) VALUES ('".$nome."', ".$instituicao.");");
        }
        
        //Função para Deletar Turmas no Banco de Dados
        public function deleteTurma($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("DELETE FROM turmas WHERE turma_codigo=".$codigo.";");
        }
        
        //Função para Consultar Turmas no Banco de Dados
        public function consultaTurma($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM turmas WHERE turma_codigo=".$codigo.";");
        }
        
        //Função para Alterar Turmas no Banco de Dados
        public function alteraTurma($codigo, $nome, $instituicao){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("UPDATE turmas SET turma_nome='".$nome."', turma_instituicao=".$instituicao." WHERE turma_codigo=".$codigo.";");
        }
	}	
?>