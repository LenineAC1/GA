<?php
/**
 * Created by PhpStorm.
 * User: Lenine
 * Date: 13/06/2018
 * Time: 18:20
 */

date_default_timezone_set('America/Sao_Paulo'); // Defina data como do Brasil/são paulo

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
    $query_select_contaTipo = $conexao_pdo->prepare("SELECT tipo  FROM `user` WHERE ID = :idConta"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_contaTipo->bindParam(':idConta', $idConta);
    if ($query_select_contaTipo->execute()){
        $queryResultTipo = $query_select_contaTipo->fetch(PDO::FETCH_ASSOC); // passa resultado da query para um array
        if (count($queryResultTipo) >= 1) {
            $Tipo=$queryResultTipo['tipo'];
            if($Tipo == 'coordenador'){
                $query_select_agendamentos = $conexao_pdo->prepare("SELECT * FROM agendamento ORDER BY SUBSTR( DATA, 5, 4) DESC, SUBSTR( DATA, 3, 2) DESC, SUBSTR( DATA, 1, 2) DESC, HORARIO ASC"); //prepara a query de seleção onde as informações são correspondentes
                if ($query_select_agendamentos->execute()){
                    $queryResult = $query_select_agendamentos->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array
                    if (count($queryResult) >= 1) {
                        return $queryResult;
                    }else{
                        $queryResult=array();
                        return $queryResult;
                    }
                }
            }else{
                $query_select_agendamentos = $conexao_pdo->prepare("SELECT *  FROM `agendamento` WHERE FK_Conta_ID = :idConta  ORDER BY SUBSTR( DATA, 5, 4), SUBSTR( DATA, 3, 2), SUBSTR( DATA, 1, 2), HORARIO ASC"); //prepara a query de seleção onde as informações são correspondentes
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
            }
        }else{
            $queryResult=array();
            return $queryResult;
        }
    }

};
//Fim: Pegar agendamentos da conta

function getHorarioByID($idHorario){
    $IDhorarioArray = explode(",",$idHorario);

    $HorarioArray = array(
        1 => "1º Aula", 2 => "2º Aula", 3 => "3º Aula",
        4 => "4º Aula", 5 => "5º Aula", 6 => "6º Aula",
        7 => "7º Aula", 8 => "8º Aula", 9 => "9º Aula",
    );
    foreach ($IDhorarioArray as $key=>$value){
        foreach ($HorarioArray as $key2=>$value2){
            if ($value == $key2){
                $IDhorarioArray[$key] = $value2."<br>";
            }
        }

        $horario = implode(" ", $IDhorarioArray);
    }

    return $horario;
};

function getAgendamentoByID($idAgendamento){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
    $query_select_Agendamento = $conexao_pdo->prepare("SELECT *  FROM `agendamento` WHERE ID = :idAgen"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_Agendamento->bindParam(':idAgen', $idAgendamento);
    if ($query_select_Agendamento->execute()){
        $queryResultAgendamento = $query_select_Agendamento->fetch(PDO::FETCH_ASSOC);
        if (count($queryResultAgendamento) >= 1) {
            return $queryResultAgendamento;
        }else{
           return null;
        }
    }else{
        return null;
    }
};

function dataCompletaPTBR($dia,$mes,$barra){
    if ($barra !== null) {
        return $dataCompleta = sprintf("%02d", $dia) . "$barra" . $mes . "$barra" . date("Y");
    }else{
        return $dataCompleta = sprintf("%02d", $dia)  . $mes  . date("Y");
    }
}

function getFeedbackByID($idFeed){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
    $query_select_Feed = $conexao_pdo->prepare("SELECT * FROM `feedback_uso` WHERE FK_Agendamento_ID = :idFeed"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_Feed->bindParam(':idFeed', $idFeed);
    if ($query_select_Feed->execute()){
        $queryResultFeed = $query_select_Feed->fetch(PDO::FETCH_ASSOC);
            return $queryResultFeed;
    }else{
        return null;
    }
};

function getUserByID($idUser){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
    $query_select_User = $conexao_pdo->prepare("SELECT * FROM `user` WHERE ID = :idUser"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_User ->bindParam(':idUser', $idUser);
    if ($query_select_User->execute()){
        $queryResultUser = $query_select_User->fetch(PDO::FETCH_ASSOC);
        return $queryResultUser;
    }else{
        return null;
    }
}

function getLABbyID($idLab){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
    $query_select_Lab = $conexao_pdo->prepare("SELECT *  FROM `o_a` WHERE ID = :idLab"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_Lab->bindParam(':idLab', $idLab);
    if ($query_select_Lab->execute()){
        $queryResultLab = $query_select_Lab->fetch(PDO::FETCH_ASSOC);
            return $queryResultLab;

    }else{
        return null;
    }
}

function RemoveNotifi($idAgen){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados
    $query_uptade_agendamento = $conexao_pdo->prepare("UPDATE `agendamento` SET Notfi = '0' WHERE `agendamento`.`ID` = :idAgendamento;");
    $query_uptade_agendamento->bindParam(':idAgendamento', $idAgen);
    $query_uptade_agendamento->execute();

}

function getNomeLabByID($id_lab)
{
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

    $query_lab_id = $conexao_pdo->prepare("SELECT `NOME` FROM `o_a` WHERE `ID` = $id_lab "); //prepara a query de seleção onde as informações são correspondentes
    $query_lab_id->execute();
    $queryResult_lab_id = $query_lab_id->fetch(PDO::FETCH_ASSOC); // passa resultado da query para um array

    if (count($queryResult_lab_id) >= 1) {// checa se foram encontrados resultados

        return $queryResult_lab_id['NOME'];
    }
}

function getDescricaoByID($id_lab){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

    $query_lab_id = $conexao_pdo->prepare("SELECT `DESCRICAO` FROM `o_a` WHERE `ID` = $id_lab "); //prepara a query de seleção onde as informações são correspondentes
    $query_lab_id->execute();
    $queryResult_lab_id = $query_lab_id->fetch(PDO::FETCH_ASSOC); // passa resultado da query para um array

    if (count($queryResult_lab_id) >= 1) {// checa se foram encontrados resultados

        return $queryResult_lab_id['DESCRICAO'];
    }
}

function calcularMediaFeed($id_lab){
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

    $query_media = $conexao_pdo->prepare("SELECT CONDICAO FROM `feedback_uso` WHERE FK_O_A_ID = $id_lab"); //prepara a query de seleção onde as informações são correspondentes
    $query_media->execute();
    $query_mediaResult =  $query_media->fetchall(PDO::FETCH_ASSOC); // passa resultado da query para um array

    if (count($query_mediaResult) >= 1) {// checa se foram encontrados resultados

        foreach ($query_mediaResult as $key => $value){

            $query_mediaResult[$key] = $value['CONDICAO'];

        }

        $media_total = round(array_sum($query_mediaResult)/count($query_mediaResult));


        return $media_total;
    }else{
        return 4;
    }
}

function getCondicaoFraseFeed($condicao){
    $condicaoArray = array(
        1 => "Ótimo, sem problemas durante o uso.", 2 => "Mediano, alguns componentes estavam comprometidos.", 3 => "Ruim, o uso foi afetado negativamente.",4 => "Sem dados suficientes",
    );


    return $condicaoArray[$condicao];
}


function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

?>