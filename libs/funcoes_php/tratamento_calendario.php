<?php
/*                ID's e Classes               */
// Table completa(id) = tabela_mes
// td do nome do mes(id) = td_nome_mes
// tr do nome do mes(id) = tr_nome_mes
// td dos dias da semana(classe) = td_dias_semana
// tr dos dias da semana(classe) = tr_dias_semana
// td dos dias do mes(clase) = td_dia_mes
// tr dos dias do mes(clase) = tr_dia_mes
// link dos dias do mes(id) = link_dia_(dia)
// link dos dias do mes(classe) = C_link_dia
/*--------------------------------------------*/


$raiz = 'http://' . $_SERVER['HTTP_HOST'] . "/GA";

require_once 'funcoes_global.php';

if (session_id() == '') {
    session_start();
}

if (isset($_GET['mes'])) {
    if (is_numeric($_GET['mes']) && $_GET['mes'] >0 && $_GET['mes']<13){
        $view_mes_atual = sprintf("%02d",$_GET['mes']);
    }else{
        $view_mes_atual = date('m');
    }
} else if (isset($_GET['atual'])) {
    if (is_numeric($_GET['atual']) && $_GET['atual'] >0 && $_GET['atual']<13){
        $view_mes_atual = sprintf("%02d",$_GET['atual']);
    }else{
        $view_mes_atual = date('m');
    }

} else if (!isset($_GET['atual'])) {
    $view_mes_atual = date('m');
    $_SESSION['last_mes'] = date('m');
}


function setas($lado)
{
    if (isset($_GET['mes'])) {
        if (is_numeric($_GET['mes']) && $_GET['mes'] >0 && $_GET['mes']<13){
            $view_mes_atual = sprintf("%02d",$_GET['mes']);
        }else{
            $view_mes_atual = date('m');
        }
        if ($view_mes_atual > 1 && $lado == "esq") {

            echo "<p><a href=?atual=" . ($view_mes_atual - 1) . "#cal><i class=\"medium material-icons cyan-text text-darken-1\">chevron_left</i></a></p>";
        }
        if ($view_mes_atual < 12 && $lado == "dir") {
            echo "<a href=?atual=" . ($view_mes_atual + 1) . "#cal style=\"float: right\"><i class=\"medium material-icons cyan-text text-darken-1\">chevron_right</i></a>";
        }
    } else
        if (isset($_GET['atual'])) {
            if (is_numeric($_GET['atual']) && $_GET['atual'] >0 && $_GET['atual']<13){
                $view_mes_atual = sprintf("%02d",$_GET['atual']);
            }else{
                $view_mes_atual = date('m');
            }
            if ($view_mes_atual > 1 && $lado == "esq") {

                echo "<p><a href=?atual=" . ($view_mes_atual - 1) . "#cal><i class=\"medium material-icons cyan-text text-darken-1\">chevron_left</i></a></p>";
            }
            if ($view_mes_atual < 12 && $lado == "dir") {
                echo "<a href=?atual=" . ($view_mes_atual + 1) . "#cal style=\"float: right\"><i class=\"medium material-icons cyan-text text-darken-1\">chevron_right</i></a>";

            }
        } else if (!isset($_GET['atual'])) {
            $view_mes_atual = date('m');
            $_SESSION['last_mes'] = date('m');
            if ($view_mes_atual > 1 && $lado == "esq") {

                echo "<p><a href=?atual=" . ($view_mes_atual - 1) . "#cal><i class=\"medium material-icons cyan-text text-darken-1\">chevron_left</i></a></p>";
            }
            if ($view_mes_atual < 12 && $lado == "dir") {
                echo "<a href=?atual=" . ($view_mes_atual + 1) . "#cal style=\"float: right\"><i class=\"medium material-icons cyan-text text-darken-1\">chevron_right</i></a>";

            }
        }
}




function MostreSemanas()
{
    $semanas = "DSTQQSS";

    for ($i = 0; $i < 7; $i++)
        echo "<td  class='td_dias_semana'>" . $semanas{$i} . "</td>"; //MOSTRA DIAS DA SEMANA (D S T Q Q S S)

}

function GetNumeroDias($mes)
{
    $numero_dias = array(
        '01' => 31, '02' => 28, '03' => 31, '04' => 30, '05' => 31, '06' => 30,
        '07' => 31, '08' => 31, '09' => 30, '10' => 31, '11' => 30, '12' => 31
    );

    if (((date('Y') % 4) == 0 and (date('Y') % 100) != 0) or (date('Y') % 400) == 0) {

        $numero_dias['02'] = 29;    // altera o numero de dias de fevereiro se o ano for bissexto

    }

    return $numero_dias[$mes];
}

function GetNomeMes($mes)
{
    $meses = array('01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
        '04' => "Abril", '05' => "Maio", '06' => "Junho",
        '07' => "Julho", '08' => "Agosto", '09' => "Setembro",
        '10' => "Outubro", '11' => "Novembro", '12' => "Dezembro"
    );

    if ($mes >= 01 && $mes <= 12)
        return $meses[$mes];

    return "Mês deconhecido";

}

function isWeekend($date)
{
    return (date('N', strtotime($date)) >= 6);
}

function MostreCalendario($mes, $lab)
{


    $_SESSION['datasProibidas'] = array();
    $conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

    $query_pedido = $conexao_pdo->prepare("select * from agendamento"); //prepara a query de seleção onde as informações são correspondentes
    $query_pedido->execute();
    $queryResult_pedido = $query_pedido->fetchAll(PDO::FETCH_ASSOC); // passa resultado da query para um array


    if (count($queryResult_pedido) > 1) {// checa se foram encontrados resultados


            foreach ($queryResult_pedido as &$value) {
                $dataAgendamento = substr($value['DATA'], 4, 4) . "-" . substr($value['DATA'], 2, 2) . "-" . substr($value['DATA'], 0, 2);
                $timestamp_dt = strtotime($dataAgendamento); // converte para timestamp Unix
                $timestamp_dt_expira = strtotime(date("Y-m-d"));
                if ($timestamp_dt < $timestamp_dt_expira) {
                }else {
                $dias_marcados[] = $value['DATA'];
                $lab_marcados[] = $value['FK_O_A_ID'];

                $dias_marcados = array_unique($dias_marcados);
            }
        }

    } else {
        $dias_marcados[] = 0;
        $lab_marcados[] = 0;
    }
    $arrayHORARIOSFull=null;



    $numero_dias = GetNumeroDias($mes);    // retorna o número de dias que tem o mês desejado
    $nome_mes = GetNomeMes($mes);
    $diacorrente = 0;

    $diasemana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes, "01", date('Y')), 0);    // função que descobre o dia da semana



    echo "<table id = 'tabela_mes' class='centered striped'>"; // TABELA PRINCIPAL ( TAG DE INICIO )
    echo "<tr id='tr_nome_mes'>";
    echo "</tr>";
    echo "<tr class='tr_dias_semana'>";
    MostreSemanas();    // função que mostra as semanas aqui
    echo "</tr>";
    for ($linha = 0; $linha < 6; $linha++) {


        echo "<tr class='tr_dia_mes'>";

        for ($coluna = 0; $coluna < 7; $coluna++) {
            echo "<td ";


            if (($diacorrente + 1) <= $numero_dias) {
                if ($coluna < $diasemana && $linha == 0) {
                    echo " id = 'dia_branco' ";
                } else {
                    foreach ($dias_marcados as $chave => $valor) {
                        $str_dias_marcados = $dias_marcados[$chave];
                        $query_limite = $conexao_pdo->prepare("SELECT * FROM agendamento WHERE DATA = $str_dias_marcados"); //prepara a query de seleção onde as informações são correspondentes
                        $query_limite->execute();
                        $queryResult_limite = $query_limite->fetchall(PDO::FETCH_ASSOC); // passa resultado da query para um array

                       foreach ($queryResult_limite as $key => $value){
                           if (substr($value['DATA'], 0, 2) == ($diacorrente + 1)){

                               $arrayHORARIOSFull .= $value['HORARIO'];
                                if (strlen(filter_var($arrayHORARIOSFull, FILTER_SANITIZE_NUMBER_INT)) == 9){
                                    foreach ($lab_marcados as $chave2 => $valor2) {
                                        $str_lab_marcados = $lab_marcados[$chave];
                                        if ($str_lab_marcados == $lab) {
                                            if (substr($str_dias_marcados, 0, 2) == ($diacorrente + 1) && substr($str_dias_marcados, 2, 2) == $mes) {
                                                echo " id = 'dia_comum' style ='border: 1px red dashed;";
                                            } else {
                                                echo " id = 'dia_comum'";
                                            }
                                        } else {
                                            echo " id = 'dia_comum'";
                                        }
                                    }
                                }

                           }


                       }

                    }
                }
            } else {
                echo "id = 'dia vazio' style = 'display: none'";
            }
            echo "class='td_dia_mes '>";

            /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO É MOSTRADO UM DIA DO CALENDÁRIO (MUITA ATENÇÃO NA HORA DA MANUTENÇÃO) */



            if($diacorrente > 30){
                $datacorridaDT = date('Y')."-".$mes."-".($diacorrente);
            }else{
                $datacorridaDT = date('Y')."-".$mes."-".($diacorrente+1);
            }
            $datacorridaDT = New DateTime($datacorridaDT);

            $dataAtualDT = New DateTime(date('Y-m-d'));


            $intervalo = $dataAtualDT->diff($datacorridaDT);

            if ($diacorrente + 1 <= $numero_dias) {
                if ($coluna < $diasemana && $linha == 0) {
                    echo " ";
                } else if ($mes < date('m') || isWeekend(date('y') . '-' . $mes . '-' . ($diacorrente + 1)) || $intervalo->format("%r%a") > 8 || $intervalo->format("%r%a") < 0) {
                    echo ++$diacorrente;
                    array_push($_SESSION['datasProibidas'], sprintf("%02d", $diacorrente) . "/" . $mes . "/" . date('Y'));
                } else {

                    echo "<a href = '" . $_SERVER["PHP_SELF"] . "?mes=$mes&dia=" . ($diacorrente + 1) . "&pedido' id='link_dia_" . ($diacorrente + 1) . "' class='C_link_dia red-text text-darken-3 abrir_modal'>" . ++$diacorrente . "</a>";

                }
            } else {
                break;
            }

            /* FIM DO TRECHO MUITO IMPORTANTE */


            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}


?>