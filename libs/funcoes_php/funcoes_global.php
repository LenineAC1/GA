<?php
/**
 * Created by PhpStorm.
 * User: Lenine
 * Date: 13/06/2018
 * Time: 18:20
 */

//Inicio: Realizar conexão com DB
function conexao_pdo($nome_db, $user_db, $senha_db ){

    try{
        $conexao_pdo = new PDO('mysql:host=localhost;charset=utf8;dbname='.$nome_db, $user_db, $senha_db);
        return $conexao_pdo;
    }catch (PDOException $e)/*Exception propia do PDO*/{
        //Mostra o erro e acaba com o script
        echo "Erro no PDO: ".$e->getMessage()."</br>";
        die();
    }
}
//Fim: Realizar conexão com DB

//Inicio: Auto loader de classes - SEM USO
function __autoload( $class ){
    $class = strtolower( $class );
    include_once ("Classes/{$class}.php");
}
//Fim: Auto loader de classes

//Inicio: Tirar caracteres especiais (exceto @ e .)
function remover_caracteres($string)
{
    $modString = preg_replace('/[^[:alnum:](@)(.)_]/', '', $string);
    return $modString;
}
//Fim: Tirar caracteres especiais


?>