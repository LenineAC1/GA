<?php
/**
 * Created by PhpStorm.
 * User: Le9
 * Date: 03/10/2018
 * Time: 20:03
 */

$raiz = 'http://' . $_SERVER['HTTP_HOST'] . "/GA";

require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';

$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

if (session_id() == '') {
    session_start();
}

$arrayAgendamentos_Notifi = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta
$countNotifi=0;
foreach ($arrayAgendamentos_Notifi as $arrayAgendamentos_Notifi) {
    if ($arrayAgendamentos_Notifi['Notfi'] == '1') {
        $dataAgendamento = substr($arrayAgendamentos_Notifi['DATA'], 4, 4) . "-" . substr($arrayAgendamentos_Notifi['DATA'], 2, 2) . "-" . substr($arrayAgendamentos_Notifi['DATA'], 0, 2);
        $timestamp_dt = strtotime($dataAgendamento); // converte para timestamp Unix
        $timestamp_dt_expira = strtotime(date("Y-m-d"));
        if ($timestamp_dt < $timestamp_dt_expira) {
        } else {
            $countNotifi++;
        }
    }
}
$htmlPart="";
$_SESSION['countnotifi']=$countNotifi;
$arrayAgendamentos_Notifi2 = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta
if ($_SESSION['countnotifi'] > 0) {
    foreach ($arrayAgendamentos_Notifi2 as $arrayAgendamentos_Notifi2) {
        if ($arrayAgendamentos_Notifi2['Notfi'] == '1') {
            if ($arrayAgendamentos_Notifi2['ESTADO_AGENDAMENTO'] == "confirmado") {
                $solicitacao = "SOLICITAÇÃO ACEITA";
                $lilSolicitacao = "aceita";
            } else {
                $solicitacao = "SOLICITAÇÃO NEGADA";
                $lilSolicitacao = "negada";
            }
            $lab = getLABbyID($arrayAgendamentos_Notifi2['FK_O_A_ID']);

            $dataAgendamento2 = substr($arrayAgendamentos_Notifi2['DATA'], 4, 4) . "-" . substr($arrayAgendamentos_Notifi2['DATA'], 2, 2) . "-" . substr($arrayAgendamentos_Notifi2['DATA'], 0, 2);

            $timestamp_dt2 = strtotime($dataAgendamento2); // converte para timestamp Unix
            $timestamp_dt_expira2 = strtotime(date("Y-m-d"));
            if ($timestamp_dt2 < $timestamp_dt_expira2) {
            } else {
                $htmlPart .= "
                           <!--Estrutura da Notificação-->
                            <li class=\"collection-item avatar\">
                            <div id=" . $arrayAgendamentos_Notifi2['ID'] . " class='agendNotf'>
                                <span class=\"title\">$solicitacao</span> <!--Estado da solicitação-->
                                <p>Sua solicitação do <span>" . $lab['NOME'] . "</span>, <!--Nome do lab solicitado-->
                                    para o dia <span>$dataAgendamento2</span> durante a ".getHorarioByID($arrayAgendamentos_Notifi2['HORARIO'])." para o curso ".$arrayAgendamentos_Notifi2['CURSO'].", <!--data solicitada-->
                                    foi <span>$lilSolicitacao</span>. <!--Estado da solicitação-->
                                </p>
                                </div>
                            </li>
                            
                         ";
            }


        }
    }
}else{
    $htmlPart = "
                           <!--Estrutura da Notificação-->
                            <li class=\"collection-item avatar\">
                            
                                <h6>Nada por enquanto, verifique mais tarde <i class='material-icons' style='vertical-align: middle'>mood_bad</i></h6>
                                
                            </li>
                            
                         ";
}

if($_SESSION['countnotifi']>0){
    $pulseclass="pulse";
}else{
    $pulseclass = "";
}
$returnArr = [$htmlPart,$_SESSION['countnotifi'],$pulseclass];
echo json_encode($returnArr);