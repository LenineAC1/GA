<?php

require_once '../../funcoes_php/funcoes_global.php';

if($_POST) {
    session_start();
    if(strlen($_POST["login_email"]) > 6 && strlen($_POST["login_senha"]) > 1) {

        $conexao_pdo = conexao_pdo('lobmanager_db', 'root', '');

        $inputs_login = $_POST;

        $inputs_login["login_senha"] = md5(md5($inputs_login["login_senha"]));

        $inputs_loginSC = remover_caracteres($inputs_login);


        $login_email = $inputs_loginSC['login_email'];

        $login_senha = $inputs_loginSC['login_senha'];

        $query = $conexao_pdo->prepare("select EMAIL, SENHA from user where EMAIL = '$login_email' and SENHA = '$login_senha'");

        $query->execute();

        $queryResult = $query->fetch(PDO::FETCH_ASSOC);

        if(count($queryResult) > 1){
            $_SESSION['session_login'] = $login_email;
            header("location: ../../../app/view/schedulingPage/schedulingPage.php");
        }else{
            header("location: ../../../index.php?error=1");
        }



        var_dump($queryResult);

        var_dump($inputs_loginSC);

    }else{
        header("location: ../../../index.php?error=1");
    }

}else{
    header("location: ../../../index.php?error=1");
}

?>