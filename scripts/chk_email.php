<?php

include "../classes/conexao.class.php";

$conexao = new Conexao();
$email = $_POST['txt_email'];
$data = array();

$query = ("SELECT user_email FROM usuarios WHERE user_email = '{$email}';");
$resultado = $conexao->executaComando($query) or die("ERRO : ".$query);

    if(mysqli_num_rows($resultado) != 0){
        $vetor = array(
            "txt_email" => $email,
        );
        
        array_push($data, $vetor);
        echo json_encode($data);
    }else{
        echo json_encode(0);
    }

?>