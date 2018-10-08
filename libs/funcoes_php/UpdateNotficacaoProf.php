<?php
/**
 * Created by PhpStorm.
 * User: Le9
 * Date: 27/09/2018
 * Time: 14:41
 */
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

require_once 'funcoes_global.php';

if(session_id() == '') {
    session_start();
}


$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados




$array = explode(',',$_POST['idsLab']);

foreach ($array as $key => $value){

    $query = $conexao_pdo->prepare("UPDATE `agendamento` SET `Notfi` = '0' WHERE `agendamento`.`ID` = :id"); //prepara a query de seleção onde as informações são correspondentes
    $query ->bindParam(':id', $value);
    $query->execute();
   echo $_POST['idsLab'];
}