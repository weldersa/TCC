<!--
DATA: 25/05/16    
ARQUIVO: pergunta_alternativa.class.php
DESCRIÇÃO: Classe modelo - Pergunta_Alternativa
--> 

<?PHP
    class Pergunta_alternativa{
        
        //Atributos
        private $alternativas;
        
        //GETs
        public function getAlternativa($numAlternativa){
            return $this->alternativas["alternativa_0".$numAlternativa];
        }
        
        //SETs
        public function setAlternativa($numAlternativa, $perg_codigo, $texto, $correta){
            $this->alternativas['alternativa_0'.$numAlternativa] = array(
                "ordem" => $numAlternativa,
                "perg_codigo" => $perg_codigo,
                "texto" => $texto,
                "correta" => $correta,
            );
        }        
        
        //Daqui pra baixo tem que arrumar pq está errado
        
        //Metodos
        public function insertAlternativa($alternativa){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            
            $query = "INSERT INTO perguntas_alternativas VALUES (".$alternativa['perg_codigo'].", '".$alternativa['texto']."', ".$alternativa['ordem'].", ".$alternativa['correta'].");";
            $conexao->executaComando($query) or die("É, parece que deu erro na inserção da alternativa ".$alternativa['ordem']." da pergunta com o código: ".$alternativa['perg_codigo']."...<br><br>".$query);;

        }
        
        public function consultaAlternativas($perg_codigo){
            require_once 'classes/conexao.class.php';
            $conexao = new Conexao();
            return $conexao->executaComando("SELECT * FROM perguntas_alternativas WHERE perg_codigo=".$perg_codigo.");");
        }
        
        public function alteraAlternativas(){
            /*-Quando o usuário alterar o número de alternativas de uma pergunta após a mesma estar inserida no banco, ele deve verificar se o numero de alternativas foi alterado e caso tenha sido, adicionar ou remover as  alternativa a mais ou a menos*/
        }
        
        public function removeAlternativas(){
            /*Remove todas as alternativas de uma pergunta*/
        }
    }
?>