<?php

$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

require_once '../../funcoes_php/funcoes_global.php';
require_once '../../funcoes_php/tratamento_calendario.php';
$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
if(session_id() == '') {
    session_start();
}

if (isset($_POST)) {

    $POST_TRATADO = $_POST;
    $POST_TRATADO['textarea_feedback'] = nl2br($POST_TRATADO['textarea_feedback']);
    //checa se ja tem agendado
    $query_select_igual = $conexao_pdo->prepare("SELECT * FROM `feedback_uso` WHERE `FK_Conta_ID` = :idConta AND `FK_Agendamento_ID` = :idAgend"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_igual->bindParam(':idConta', $POST_TRATADO['id_conta_feedback']);
    $query_select_igual->bindParam(':idAgend', $POST_TRATADO['id_agendamento_feedback']);
    if($query_select_igual->execute()){
        $queryResult = $query_select_igual->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array

        if (count($queryResult) >= 1){
            header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
            $_SESSION['retorno_feedback']='erro';
        }else{
            $query_insert = $conexao_pdo->prepare("INSERT INTO `feedback_uso` (`ID`, `TEXTO_FEEDBACK`, `CONDICAO`, `FK_Conta_ID`, `FK_Agendamento_ID`) VALUES (NULL, :textFeed, :condicao, :idConta, :idAgend);"); //prepara a query de seleção onde as informações são correspondentes
            $query_insert->bindParam(':textFeed', $POST_TRATADO['textarea_feedback']);
            $query_insert->bindParam(':condicao', $POST_TRATADO['select_feedback']);
            $query_insert->bindParam(':idConta', $POST_TRATADO['id_conta_feedback']);
            $query_insert->bindParam(':idAgend', $POST_TRATADO['id_agendamento_feedback']);
            if($query_insert->execute()){
                header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
                $_SESSION['retorno_feedback']='exito';

            }else{
                header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
                $_SESSION['retorno_feedback']='erro';
                $_SESSION['dados']=$conexao_pdo->errorInfo();

            }
        }
    }else{
        header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
        $_SESSION['retorno_feedback']='erro';
    }
}else{
    header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
    $_SESSION['retorno_feedback']='erro';
}

?>