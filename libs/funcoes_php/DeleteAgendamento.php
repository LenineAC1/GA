<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/tratamento_calendario.php';
if (session_id() == '') {
    session_start();
}
$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
if(isset($_POST)){
        $query= $conexao_pdo->prepare("DELETE FROM `agendamento` WHERE `agendamento`.`ID` = :id;");
        $query->bindParam(':id', $_POST['name']);
        if ($query->execute()){
            echo $_POST['name'];
        }
    }
