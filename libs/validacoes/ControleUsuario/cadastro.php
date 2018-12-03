<?php

$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

require_once '../../funcoes_php/funcoes_global.php';

if(session_id() == '') {
    session_start();
}


$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados


$senha = generateRandomString(5 );
$senhaMD5 = md5(md5($senha));

$required = array('email', 'primeiro_nome', 'sobrenome','opcTipo');


$error = false;
foreach($required as $field) {
    if (empty($_POST[$field])) {
        $error = true;
    }
}

if ($error) {
    header("location: $raiz/app/view/pgAdmin/pgAdmin.php");
    $_SESSION['retorno_cadastro'] = 'erro';
} else {
    $nomeCompleto = $_POST['primeiro_nome']." ".$_POST['sobrenome'];
    if ($_POST['opcTipo']==1){
        $tipo = "professor";
        $permicao = "prof_perm_first";
    }else if($_POST['opcTipo']==2){
        $tipo = "coordenador";
        $permicao = "coord_perm_first";
    }

    $query_select_igual = $conexao_pdo->prepare("SELECT * FROM `user` WHERE `EMAIL` = :email"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_igual->bindParam(':email', $_POST['email']);
    if ($query_select_igual->execute()) {
        $queryResult = $query_select_igual->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array

        if (count($queryResult) >= 1) {
            header("location: $raiz/app/view/pgAdmin/pgAdmin.php");
            $_SESSION['retorno_cadastro'] = 'erro';
        } else {
            $query_insert = $conexao_pdo->prepare("INSERT INTO `user` (`ID`, `EMAIL`, `SENHA`, `NOME`, `TIPO`, `PERMISSAO`) VALUES (NULL, :email, :senha, :nome, :tipo, :perm);"); //prepara a query de seleção onde as informações são correspondentes
            $query_insert->bindParam(':email', $_POST['email']);
            $query_insert->bindParam(':senha', $senhaMD5);
            $query_insert->bindParam(':nome', $nomeCompleto);
            $query_insert->bindParam(':tipo', $tipo);
            $query_insert->bindParam(':perm', $permicao);
            if ($query_insert->execute()) {
                $_SESSION['firstSenha'] = $senha;
                header("location: $raiz/app/view/pgAdmin/pgAdmin.php");
                $_SESSION['retorno_cadastro'] = 'exito';
            } else {// caso não encontre resultados da query retorna para index com uma sessão de erro
                header("location: $raiz/app/view/pgAdmin/pgAdmin.php");
                $_SESSION['retorno_cadastro'] = 'erro';
            }
        }
    } else { // caso os campos não estajam devidamente preenchidos retorna para index com uma sessão de erro
            header("location: $raiz/app/view/pgAdmin/pgAdmin.php");
            $_SESSION['retorno_cadastro'] = 'erro';
        }
}
?>