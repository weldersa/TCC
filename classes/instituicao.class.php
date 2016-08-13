<!--
DATA: 03/05/16    
ARQUIVO: instituicao.class.php
DESCRIÇÃO: Classe modelo - Instituição
-->     

<?PHP
	class Instituicao{
		//Atributos
		private $codigo;
		private $nome;
		private $rua;
		private $numero;
		private $cep;
		private $bairro;
		private $cidade;
		private $estado;
		private $pais;
		private $telefone;
		private $email;
		private $senha;
		private $documento_tipo;
		private $numero_documento;
		
		//Construtor com parâmetros
		public function __construct($nome, $rua, $numero, $cep, $bairro, $cidade, $estado, $pais, $telefone, $email, $senha, $documento_tipo, $numero_documento){
			$this->nome = $nome;
			$this->rua = $rua;
			$this->numero = $numero;
			$this->cep = $cep;
			$this->bairro = $bairro;
			$this->cidade = $cidade;
			$this->estado = $estado;
			$this->pais = $pais;
			$this->telefone = $telefone;
			$this->email = $email;
			$this->senha = $senha;
			$this->documento_tipo = $documento_tipo;
			$this->numero_documento = $numero_documento;
		}
		
		//Getters
		public function getCodigo(){
			return $this->codigo;
		}
		public function getNome(){
			return $this->nome;
		}
		public function getRua(){
			return $this->rua;
		}
		public function getNumero(){
			return $this->numero;
		}
		public function getCep(){
			return $this->cep;
		}
		public function getBairro(){
			return $this->bairro;
		}
		public function getCidade(){
			return $this->cidade;
		}
		public function getEstado(){
			return $this->estado;
		}
		public function getPais(){
			return $this->pais;
		}
		public function getTelefone(){
			return $this->telefone;
		}
		public function getEmail(){
			return $this->email;
		}
		public function getSenha(){
			return $this->senha;
		}
		public function getDocumentoTipo(){
			return $this->documento_tipo;
		}
		public function getNumeroDocumento(){
			return $this->numero_documento;
		}
		
		//Setters
		public function setNome($nome){
			$this->nome = $nome;
		}
		public function setRua($rua){
			$this->rua = $rua;
		}
		public function setNumero($numero){
			$this->numero = $numero;
		}
		public function setCep($cep){
			$this->cep = $cep;
		}
		public function setBairro($bairro){
			$this->bairro = $bairro;
		}
		public function setCidade($cidade){
			$this->cidade = $cidade;
		}
		public function setEstado($estado){
			$this->estado = $estado;
		}
		public function setPais($pais){
			$this->pais = $pais;
		}
		public function setTelefone($telefone){
			$this->telefone = $telefone;
		}
		public function setEmail($email){
			$this->email = $email;
		}
		public function setSenha($senha){
			$this->senha = $senha;
		}
		public function setDocumentoTipo($documento_tipo){
			$this->documento_tipo = $documento_tipo;
		}
		public function setNumeroDocumento($numero_documento){
			$this->numero_documento = $numero_documento;
		}
		
		//Métodos
		//Função para Inserir Instituições no Banco de Dados
        public function insertInst(){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
			$query1 = "INSERT INTO usuarios VALUES ('{$this->email}', '{$this->senha}', '{$this->nome}', 'I');";
			$query2 = "INSERT INTO instituicoes (inst_email, inst_doc_tipo, inst_num_doc, inst_end_rua, inst_end_numero, inst_cep, inst_bairro, inst_cidade, inst_estado, inst_pais, inst_telefone) VALUES ('{$this->email}', '{$this->documento_tipo}', '{$this->numero_documento}', '{$this->rua}', '{$this->numero}', '{$this->cep}', '{$this->bairro}', '{$this->cidade}', '{$this->estado}', '{$this->pais}', '{$this->telefone}');";
           // return $conexao->executaComandos($query1.$query2);
			return $conexao->executaComandos($query1.$query2);
        }
        
        //Função para Deletar Instituições no Banco de Dados
        public function deleteInst($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("DELETE FROM instituicoes WHERE inst_codigo=".$codigo.";");
        }
        
        //Função para Consultar Instituição no Banco de Dados
        public function consultaInst($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM instituicoes WHERE inst_codigo=".$codigo.";");
        }
        
        //Função para Alterar Instituição no Banco de Dados
        public function alteraInst($codigo, $nome, $rua, $numero, $cep, $bairro, $cidade, $estado, $pais, $telefone, $email, $senha, $documento_tipo, $numero_documento){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("UPDATE instituicoes SET inst_nome='".$nome."', inst_end_rua='".$rua."', inst_end_numero='".$numero."',
                inst_cep='".$cep."', inst_bairro='".$bairro."', inst_cidade='".$cidade."', inst_estado='".$estado."', inst_pais='".inst_pais."',inst_telefone='".$telefone."', inst_senha='".$senha."', inst_doc_tipo='".$documento_tipo."','".$numero_documento."' WHERE inst_codigo=".$codigo.";");
        }
		
	}
?>