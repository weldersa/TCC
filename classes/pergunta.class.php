<!--
DATA: 25/05/16    
ARQUIVO: pergunta.class.php
DESCRIÇÃO: Classe modelo - Pergunta
--> 

<?PHP
    class Pergunta{
        
        //Atributos
        private $codigo;
        private $enunciado;
        private $imagem;
        private $peso;
        private $tipo;
        private $numAlternativas;
        private $numPergunta;
        private $tags;
        
        //GETs
        public function getCodigo(){
            return $this->codigo;
        }
        public function getEnunciado(){
            return $this->enunciado;
        }
        public function getImagem(){
            return $this->imagem;
        }
        public function getPeso(){
            return $this->peso;
        }
        public function getTipo(){
            return $this->tipo;
        }
        public function getNumAlternativas(){
            return $this->numAlternativas;
        }
        public function getNumPergunta(){
            return $this->numPergunta;
        }
        public function getTags(){
            return $this->tags;
        }
        
        //SETs
        public function setCodigo($codigo){
            $this->codigo = $codigo;
        }
        public function setEnunciado($enunciado){
            $this->enunciado = $enunciado;
        }
        public function setImagem($imagem){
            $this->imagem = $imagem;
        }
        public function setPeso($peso){
            $this->peso = $peso;
        }
        public function setTipo($tipo){
            $this->tipo = $tipo;
        }
        public function setNumAlternativas($numAlternativas){
            $this->numAlternativas = $numAlternativas;
        }
        public function setNumPergunta($numPergunta){
            $this->numPergunta = $numPergunta;
        }
        public function setTags($tags){
            $this->tags = $tags;
        }
        
        public function redimensionar($imagem, $largura, $pasta){

            if(file_exists($imagem["tmp_name"])){
                return $imagem["tmp_name"];
            }else{
                if(!file_exists($pasta)){
                    mkdir($pasta, 0700);
                }

                $name = md5(uniqid(rand(),true));
            
                if ($imagem['type']=="image/jpg"){
                    $img = imagecreatefromjpeg($imagem['tmp_name']);
                }else if ($imagem['type']=="image/gif"){
                    $img = imagecreatefromgif($imagem['tmp_name']);
                }else if ($imagem['type']=="image/png"){
                    $img = imagecreatefrompng($imagem['tmp_name']);
                }
                
                $x   = imagesx($img);
                $y   = imagesy($img);
                
                $altura = ($largura * $y)/$x;
            
                $nova = imagecreatetruecolor($largura, $altura);
                imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
            
                if (($imagem['type'] == "image/jpg") OR ($imagem['type'] == "image/jpeg")){
                    $local= $pasta."/".$name.".jpg";
                    imagejpeg($nova, $local);
                }else if ($imagem['type']=="image/gif"){
                    $local= $pasta."/".$name.".gif";
                    imagejpeg($nova, $local);
                }else if ($imagem['type']=="image/png"){
                    $local= $pasta."/".$name.".png";
                    imagejpeg($nova, $local);
                }		
            
                imagedestroy($img);
                imagedestroy($nova);	
            
                return $local;
            }
	    }

        //Metodos
        public function insertPergunta(){
            require_once "classes/conexao.class.php";
            $conexao = new Conexao();

            $query = "INSERT INTO perguntas (perg_enunciado, perg_imagem, perg_peso, perg_tipo, perg_numAlternativas) VALUES('".$this->enunciado."', '".$this->imagem."', ".$this->peso.", '".$this->tipo."', ".$this->numAlternativas.");";
            $cod_pergunta = $conexao->retornaId($query) or die("É, parece que deu erro na inserção da pergunta ".$this->numPergunta."...<br><br>".$query);
            
            return $cod_pergunta;
        }

        //Atribui a pergunta à um questionário
        public function atribuiQuestionario($codigo_questionario){
            require_once "classes/conexao.class.php";
            $conexao = new Conexao();

            $query = "INSERT INTO ordem_perguntas values(".$codigo_questionario.", ".$this->codigo.", ".$this->numPergunta.");";
            $conexao->executaComando($query) or die("É, parece que deu erro ao atribuir a pergunta ".$this->numPergunta." ao questionário...<br><br>".$query);
        }        

        //Salva as Tags da pergunta no banco
        public function salvaTags(){
            require_once "classes/conexao.class.php";
            $conexao = new Conexao();
            $tags = $this->tags;

            for($i = 0; $i < count($tags); $i++){
                $query = "INSERT INTO tags VALUES(".$this->codigo.", '".$tags[$i]."');";
                $conexao->executaComando($query) or die("É, parece que deu erro na inserção da tag ".$tags[$i]." na pergunta ".$this->numPergunta."...<br><br>".$query);
            }
            
        }
    }
?>