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

//Inicio: Pegar agendamentos da conta
function getAgendamendos($idConta){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
    $query_select_agendamentos = $conexao_pdo->prepare("SELECT *  FROM `agendamento` WHERE FK_Conta_ID = :idConta  ORDER BY DATA ASC, HORARIO ASC"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_agendamentos->bindParam(':idConta', $idConta);

    if ($query_select_agendamentos->execute()){
        $queryResult = $query_select_agendamentos->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array
        if (count($queryResult) >= 1) {
            return $queryResult;
            }else{
            $queryResult=array();
            return $queryResult;
        }
        }
};
//Fim: Pegar agendamentos da conta

function getHorarioByID($idHorario){
    $HorarioArray = array(
        1 => "1º Aula - 7:00 até 7:50", 2 => "2º Aula - 7:50 até 8:40", 3 => "3º Aula - 8:40 até 9:30",
        4 => "4º Aula - 9:50 até 10:40", 5 => "5º Aula - 10:40 até 11:30", 6 => "6º Aula - 11:30 até 12:20",
        7 => "7º Aula - 13:30 até 14:20", 8 => "8º Aula - 14:20 até 15:10", 9 => "9º Aula - 15:10 até 15:50",
    );
    return $HorarioArray[$idHorario];
};

function dataCompletaPTBR($dia,$mes,$barra){
    if ($barra !== null) {
        return $dataCompleta = sprintf("%02d", $dia) . "$barra" . $mes . "$barra" . date("Y");
    }else{
        return $dataCompleta = sprintf("%02d", $dia)  . $mes  . date("Y");
    }
}
?>