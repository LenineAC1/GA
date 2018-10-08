<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/tratamento_calendario.php';
if (session_id() == '') {
    session_start();
}
$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
if(isset($_GET)){
if($_GET['permissao']=="sim"){
    $query_uptade_agendamento = $conexao_pdo->prepare("UPDATE `agendamento` SET `ESTADO_AGENDAMENTO` = 'confirmado', Notfi = '1' WHERE `agendamento`.`ID` = :idAgendamento;");
    $query_uptade_agendamento->bindParam(':idAgendamento', $_GET['agendamentoID']);
    if ($query_uptade_agendamento->execute()){
        header("location: $raiz/app/view/pgCoord/pgCoord.php");
        $_SESSION['retorno_update']='exito';
    }else{
        header("location: $raiz/app/view/pgCoord/pgCoord.php");
        $_SESSION['retorno_update']='erro';
    }
}else if($_GET['permissao']=="nao"){
    $query_uptade_agendamento = $conexao_pdo->prepare("UPDATE `agendamento` SET `ESTADO_AGENDAMENTO` = 'negado', Notfi = '1' WHERE `agendamento`.`ID` = :idAgendamento;");
    $query_uptade_agendamento->bindParam(':idAgendamento', $_GET['agendamentoID']);
    if ($query_uptade_agendamento->execute()){
        header("location: $raiz/app/view/pgCoord/pgCoord.php");
        $_SESSION['retorno_update']='exito';
    }else{
        header("location: $raiz/app/view/pgCoord/pgCoord.php");
        $_SESSION['retorno_update']='erro';
    }
}
}