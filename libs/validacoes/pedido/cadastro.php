<?php

$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

require_once '../../funcoes_php/funcoes_global.php';

if(session_id() == '') {
    session_start();
}


$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados



if (isset($_POST['curso_manha'])&&isset($_POST['ano_manha'])&&isset($_POST['horario_manha'])) {
    $post_manha = array(
        "curso" => $_POST['curso_manha'],
        "ano" => $_POST['ano_manha'],
        "horario" => $_POST['horario_manha'],
        "data" => dataCompletaPTBR($_POST['dia_agendamento'],$_POST['mes_agendamento'],null),
        "id_conta" => $_POST['id_conta_agendamento'],
        "id_lab" => $_POST['lab_agendamento'],
    );
}
if (isset($_POST['curso_noite'])&&isset($_POST['ano_noite'])&&isset($_POST['horario_noite'])) {
    $post_noite = array(
        "curso" => $_POST['curso_noite'],
        "ano" => $_POST['ano_noite'],
        "horario" => $_POST['horario_noite'],
        "data" => sprintf("%02d",$_POST['dia_agendamento']).$_POST['mes_agendamento'].date('y'),
        "id_conta" => $_POST['id_conta_agendamento'],
        "id_lab" => $_POST['lab_agendamento'],
    );
}

if (isset($post_manha)){
    var_dump($post_manha);
    //checa se ja tem agendado
    $query_select_igual = $conexao_pdo->prepare("SELECT * FROM `agendamento` WHERE `HORARIO` = :horario AND `FK_Conta_ID` = :idConta AND `DATA` = :dataAgendamento AND `FK_O_A_ID` = :idLab"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_igual->bindParam(':horario', $post_manha['horario']);
    $query_select_igual->bindParam(':idConta', $post_manha['id_conta']);
    $query_select_igual->bindParam(':dataAgendamento', $post_manha['data']);
    $query_select_igual->bindParam(':idLab', $post_manha['id_lab']);
    if($query_select_igual->execute()){
        $queryResult = $query_select_igual->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array

        if (count($queryResult) >= 1){
            header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
            $_SESSION['retorno_pedido']='erro';
        }else{
            echo "deu certo";
            $query_insert = $conexao_pdo->prepare("INSERT INTO `agendamento` (`ID`, `HORARIO`, `CURSO`, `ANO_CURSO`, `ESTADO_AGENDAMENTO`, `FK_O_A_ID`, `FK_Conta_ID`, `DATA`) VALUES (NULL, :horario, :curso, :ano, 'em analise', :idLab, :idConta, :dataAgendamento);"); //prepara a query de seleção onde as informações são correspondentes
            $query_insert->bindParam(':horario', $post_manha['horario']);
            $query_insert->bindParam(':curso', $post_manha['curso']);
            $query_insert->bindParam(':ano', $post_manha['ano']);
            $query_insert->bindParam(':idLab', $post_manha['id_lab']);
            $query_insert->bindParam(':idConta', $post_manha['id_conta']);
            $query_insert->bindParam(':dataAgendamento', $post_manha['data']);
            if($query_insert->execute()){
                header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
                $_SESSION['retorno_pedido']='exito';
            }else{
                header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
                $_SESSION['retorno_pedido']='erro';
            }
        }
    }else{
        header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
        $_SESSION['retorno_pedido']='erro';
    }


}else if (isset($post_noite)){
    var_dump($post_noite);
    //checa se ja tem agendado
    $query_select_igual = $conexao_pdo->prepare("SELECT * FROM `agendamento` WHERE `HORARIO` = :horario AND `FK_Conta_ID` = :idConta AND `DATA` = :dataAgendamento AND `FK_O_A_ID` = :idLab"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_igual->bindParam(':horario', $post_noite['horario']);
    $query_select_igual->bindParam(':idConta', $post_noite['id_conta']);
    $query_select_igual->bindParam(':dataAgendamento', $post_noite['data']);
    $query_select_igual->bindParam(':idLab', $post_noite['id_lab']);
    if($query_select_igual->execute()){
        $queryResult = $query_select_igual->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array

        if (count($queryResult) >= 1){
            header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
            $_SESSION['retorno_pedido']='erro';
        }else{
            echo "deu certo";
            $query_insert = $conexao_pdo->prepare("INSERT INTO `agendamento` (`ID`, `HORARIO`, `CURSO`, `ANO_CURSO`, `ESTADO_AGENDAMENTO`, `FK_O_A_ID`, `FK_Conta_ID`, `DATA`) VALUES (NULL, :horario, :curso, :ano, 'pedido', :idLab, :idConta, :dataAgendamento);"); //prepara a query de seleção onde as informações são correspondentes
            $query_insert->bindParam(':horario', $post_noite['horario']);
            $query_insert->bindParam(':curso', $post_noite['curso']);
            $query_insert->bindParam(':ano', $post_noite['ano']);
            $query_insert->bindParam(':idLab', $post_noite['id_lab']);
            $query_insert->bindParam(':idConta', $post_noite['id_conta']);
            $query_insert->bindParam(':dataAgendamento', $post_noite['data']);
            if($query_insert->execute()){
                header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
                $_SESSION['retorno_pedido']='exito';
            }else{
                header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
                $_SESSION['retorno_pedido']='erro';
            }
        }
    }else{
        header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
        $_SESSION['retorno_pedido']='erro';
    }
}else{
    header("location: $raiz/app/view/pgProfessor/pgProfessor.php");
    $_SESSION['retorno_pedido']='erro';
}