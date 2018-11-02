<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

require_once 'funcoes_global.php';

if(session_id() == '') {
    session_start();
}

$desc = nl2br($_POST['texto_lab']);
$nome = $_POST['nome_lab'];
$id = $_POST['id_lab'];


$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
try {
    $query = $conexao_pdo->prepare("UPDATE `o_a` SET `NOME` = :nomeLab, `DESCRICAO` = :descricao WHERE `o_a`.`ID` = :id"); //prepara a query de seleção onde as informações são correspondentes
    $query->bindParam(':nomeLab', $nome);
    $query->bindParam(':descricao', $desc);
    $query->bindParam(':id', $id);
    $query->execute();
    echo "sucesso";
}catch (PDOException $ex){
    echo "erro";
}
