<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
require_once '../../funcoes_php/funcoes_global.php';
session_start(); //Inicia sessão
if (isset($_POST)) { //Verifica se o post foi enviado(evitar erros)
    if (strlen($_POST["login_email"]) >= 6 && strlen($_POST["login_senha"]) > 3 && filter_var($_POST["login_email"],FILTER_VALIDATE_EMAIL)) { //verifica campos de email e senha, se possui numero minimo de caracteres e se é um email valido

        $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

        $inputs_login = $_POST; // pega todas as informações enviadas no POST

        $inputs_login["login_senha"] = md5(md5($inputs_login["login_senha"])); // passa a senha do POST para md5(md5);

        $inputs_loginSC = remover_caracteres($inputs_login); // Função que remove caracteres especias evitando SQL injection

        $login_email = strtolower($inputs_loginSC['login_email']); // passa o POST do login para uma variavel

        $login_senha = $inputs_loginSC['login_senha']; // passa o POST da senha para uma variavel

        $query = $conexao_pdo->prepare("select * from user where EMAIL = '$login_email' and SENHA = '$login_senha'"); //prepara a query de seleção onde as informações são correspondentes

        $query->execute(); // executa a query

        $queryResult = $query->fetch(PDO::FETCH_ASSOC); // passa resultado da query para um array

        if (count($queryResult) > 1) {// checa se foram encontrados resultados

            $_SESSION['session_login_id'] = $queryResult['ID'];
            if ($queryResult['TIPO'] == "coordenador") {// checa se tipo da conta é de coordenador
                if ($queryResult['PERMISSAO'] == "coord_perm_first"){
                    header("location: $raiz");
                    $_SESSION['erro_login'] = 2;
                }else{

                    $_SESSION['session_login'] = $login_email; // salva login realizado em uma sessão para uso posterior
                    $_SESSION['session_tipo'] = $queryResult['TIPO']; // salva tipo da conta realizado em uma sessão para uso posterior

                    header("location: $raiz/app/view/pgCoord/pgCoord.php");// redireciona para pagina de coordenador
                }
            } else if ($queryResult['TIPO'] == "professor") {// checa se tipo da conta é de professor
                if ($queryResult['PERMISSAO'] == "prof_perm_first"){
                    header("location: $raiz");
                    $_SESSION['erro_login'] = 2;
                }else{
                    $_SESSION['session_login'] = $login_email; // salva login realizado em uma sessão para uso posterior
                    $_SESSION['session_tipo'] = $queryResult['TIPO']; // salva tipo da conta realizado em uma sessão para uso posterior

                    header("location: $raiz/app/view/pgProfessor/pgProfessor.php");// redireciona para pagina de coordenador
                }
            }else if($queryResult['TIPO'] == "admin"){
                $_SESSION['session_login'] = $login_email; // salva login realizado em uma sessão para uso posterior
                $_SESSION['session_tipo'] = $queryResult['TIPO']; // salva tipo da conta realizado em uma sessão para uso posterior

                header("location: $raiz/app/view/pgAdmin/pgAdmin.php");// redireciona para pagina de coordenador
            }

        } else {// caso não encontre resultados da query retorna para index com uma sessão de erro
            header("location: $raiz");
            $_SESSION['erro_login'] = 1;
        }


    } else { // caso os campos não estajam devidamente preenchidos retorna para index com uma sessão de erro
        header("location: $raiz");
        $_SESSION['erro_login'] = 1;
    }

} else { // caso não receba o POST retorna para index com uma sessão de erro
    header("location: $raiz");
    $_SESSION['erro_login'] = 1;
}

?>