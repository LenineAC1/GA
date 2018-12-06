<?php

$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';

if(session_id() == '') {
    session_start();
}


$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados



$required = array('select_report', 'textReport');


$error = false;
foreach($required as $field) {
    if (empty($_POST[$field])) {
        $error = true;
    }
}

if ($error) {
    header("Location: ".$_SERVER['HTTP_REFERER']);
    $_SESSION['retorno_report'] = 'erro';
} else {

            $query_insert = $conexao_pdo->prepare("INSERT INTO `report` (`ID`, `tipo`, `info`) VALUES (NULL, :tipo, :text);"); //prepara a query de seleção onde as informações são correspondentes
            $query_insert->bindParam(':tipo', $_POST['select_report']);
            $query_insert->bindParam(':text', $_POST['textReport']);


            if ($query_insert->execute()) {
                $_SESSION['retorno_report'] = 'exito';
                header("Location: ".$_SERVER['HTTP_REFERER']);
            } else {// caso não encontre resultados da query retorna para index com uma sessão de erro
                header("Location: ".$_SERVER['HTTP_REFERER']);
                $_SESSION['retorno_report'] = 'erro';
            }

}
?>