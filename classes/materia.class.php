<!--
DATA: 12/05/16    
ARQUIVO: materia.class.php
DESCRIÇÃO: Classe modelo - Turma
-->

<?PHP
    class Materia{
        //Atributos
        private $codigo;
        private $nome;
    
        
        //Getters
        public function getCodigo(){
            return $this->codigo;
        }
        public function getNome(){
            return $this->nome;
        }
        
        //Setters
        public function setNome($nome){
            $this->nome = $nome;
        }
        
        //Métodos
        //Função para Inserir Matérias no Banco de Dados
        public function insertMateria(){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $cod_materia = $conexao->retornaId("INSERT INTO materias (materia_nome) VALUES ('".$this->nome."');");

            return $cod_materia;
        }
        
        //Função para Deletar Matérias no Banco de Dados
        public function deleteMateria($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("DELETE FROM materias WHERE materia_codigo=".$codigo.";");
        }
        
        //Função para Consultar Matérias no Banco de Dados
        public function consultaCodigoMateria($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM materias WHERE materia_codigo=".$codigo.";");
        }

        public function consultaNomeMateria($materia){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM materias WHERE materia_nome='".$materia."';");
        }
        
        //Função para Alterar Matérias no Banco de Dados
        public function alteraTurma($codigo, $nome, $instituicao){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("UPDATE materias SET materia_nome='".$nome."' WHERE materia_codigo=1".$codigo.";");
        }
    
    }
    
?>