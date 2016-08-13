<!--
DATA: 03/05/16    
ARQUIVO: questionario.class.php
DESCRIÇÃO: Classe modelo - Questionário
-->       

<?PHP
    class Questionario{
        //Atributos
        private $codigo;
        private $nome;
        private $professor;
        private $materia;
        private $numPerguntas;
        private $tempo;
        private $visualizaResposta;
        private $randomizarPerguntas;
        private $necessitaCorrecao;

        //Getters
        public function getCodigo(){
            return $this->codigo;
        }
        public function getNome(){
            return $this->nome;
        }
        public function getProfessor(){
            return $this->professor;
        }
        public function getMateria(){
            return $this->materia;
        }
        public function getNumPerguntas(){
            return $this->numPerguntas;
        }
        public function getTempo(){
            return $this->tempo;
        }
        public function getDataInicio(){
            return $this->dataInicio;
        }
        public function getDataFim(){
            return $this->dataFim;
        }
        public function getStatus(){
            return $this->status;
        }
        public function getVisualizaResposta(){
            return $this->visualizaResposta;
        }
        public function getRandomizarPerguntas(){
            return $this->randomizarPerguntas;
        }
        public function getNecessitaCorrecao(){
            return $this->necessitaCorrecao;
        }

        //Setters
        public function setCodigo($codigo){
            $this->codigo = $codigo;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }
        public function setProfessor($professor){
            $this->professor = $professor;
        }
        public function setMateria($materia){
            $this->materia = $materia;
        }
        public function setnumPerguntas($numPerguntas){
            $this->numPerguntas = $numPerguntas;
        }
        public function setTempo($tempo){
            $this->tempo = $tempo;
        }
        public function setDataInicio($dataInicio){
            $this->dataInicio = $dataInicio;
        }
        public function setDataFim($dataFim){
            $this->dataFim = $dataFim;
        }
        public function setStatus($status){
            $this->status = $status;
        }
        public function setVisualizaResposta($visualizaResposta){
            $this->visualizaResposta = $visualizaResposta;
        }
        public function setRandomizarPerguntas($randomizarPerguntas){
            $this->randomizarPerguntas = $randomizarPerguntas;
        }
        public function setNecessitaCorrecao($necessitaCorrecao){
            $this->necessitaCorrecao = $necessitaCorrecao;
        }
        
        //Função para Inserir Questionários no Banco de Dados
        public function insertQuest(){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            
            $query = "INSERT INTO questionarios (quest_nome, quest_professor, quest_materia, quest_numPerguntas, quest_tempo, quest_visualizar_resposta, quest_randomiza_perguntas, quest_necessita_correcao) VALUES ('".$this->nome."', '".$this->professor."', ".$this->materia.", ".$this->numPerguntas.", ".$this->tempo.", ".$this->visualizaResposta.", ".$this->randomizarPerguntas.", ".$this->necessitaCorrecao.");";
            $cod_quest = $conexao->retornaId($query) or die("É, parece que deu erro na inserção do questionário...<br><br>".$query);
            return $cod_quest;
        }
        
        //Função para Deletar Questionários no Banco de Dados
        public function deleteQuest($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("DELETE FROM questionarios WHERE quest_codigo=".$codigo.";");
        }
        
        //Função para Consultar Questionários no Banco de Dados
        public function consultaQuest($codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM questionarios WHERE quest_codigo=".$codigo.";");
        }

        public function consultaQuestProfessor($professor){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM questionarios WHERE quest_professor='".$professor."';");
        }
        
        //Função para Alterar Questionários no Banco de Dados
        public function alteraQuest($codigo, $nome, $professor, $materia, $numPerguntas, $dataInicio, $dataFim, $tempo, $status, $visualizaResposta){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            $conexao->executaComando("UPDATE questionarios SET quest_nome='".$nome."', quest_professor='".$professor."',
                quest_materia='".$materia."', quest_numPerguntas='".$numPerguntas."', quest_tempo='".$tempo."', quest_data_inicio=".$dataInicio.", quest_data_fim=".$dataFim.", quest_status=".$status.", quest_visualiza_resposta=".$visualizaResposta." WHERE quest_codigo=".$codigo.";");
        }

        //Função para aplicar o questionário à uma turma
        public function aplicaQuest($questionario, $turma, $dataInicio, $dataFim){
            require_once "classes/conexao.class.php";
            $conexao = new Conexao();
            return $conexao->executaComando("INSERT INTO questionario_turma VALUES (".$questionario.", ".$turma.", ".$dataInicio.", ".$dataFim.");");
        }
    }
?>