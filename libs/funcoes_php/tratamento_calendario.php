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

if(session_id() == '') {
    session_start();
}

if (isset($_GET['mes'])){
    $view_mes_atual = $_GET['mes'];
}else if (!isset($_GET['atual'])){
    $view_mes_atual = date('m');
    $_SESSION['last_mes'] = date('m');
}else{
    if(!isset($view_mes_atual) ) {
        $view_mes_atual = date('m');
    }
    if ($_GET['atual'] == 'mais'){
        $view_mes_atual = "0" .$_SESSION['last_mes'];
        if($view_mes_atual<12 && $view_mes_atual>=9) {
            $view_mes_atual = ++$_SESSION['last_mes'];
        }else if ($view_mes_atual<12 && $view_mes_atual<9){
            $view_mes_atual = "0".++$_SESSION['last_mes'];
        }else{
            $view_mes_atual = 12;
        };
    }else if($_GET['atual'] == 'menos'){
        $view_mes_atual = "0" .$_SESSION['last_mes'];
        if($view_mes_atual>1 && $view_mes_atual<=10) {
            $view_mes_atual = "0" . --$_SESSION['last_mes'];

        }
        else if($view_mes_atual>9){
            $view_mes_atual = --$_SESSION['last_mes'];

        }
    }
}


function MostreSemanas()
{
    $semanas = "DSTQQSS";

    for( $i = 0; $i < 7; $i++ )
        echo "<td  class='td_dias_semana'>".$semanas{$i}."</td>"; //MOSTRA DIAS DA SEMANA (D S T Q Q S S)

}

function GetNumeroDias( $mes )
{
    $numero_dias = array(
        '01' => 31, '02' => 28, '03' => 31, '04' =>30, '05' => 31, '06' => 30,
        '07' => 31, '08' =>31, '09' => 30, '10' => 31, '11' => 30, '12' => 31
    );

    if (((date('Y') % 4) == 0 and (date('Y') % 100)!=0) or (date('Y') % 400)==0)
    {
        $numero_dias['02'] = 29;	// altera o numero de dias de fevereiro se o ano for bissexto
    }

    return $numero_dias[$mes];
}

function GetNomeMes( $mes )
{
    $meses = array( '01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
        '04' => "Abril",   '05' => "Maio",      '06' => "Junho",
        '07' => "Julho",   '08' => "Agosto",    '09' => "Setembro",
        '10' => "Outubro", '11' => "Novembro",  '12' => "Dezembro"
    );

    if( $mes >= 01 && $mes <= 12)
        return $meses[$mes];

    return "Mês deconhecido";

}



function MostreCalendario( $mes  )
{

    $numero_dias = GetNumeroDias( $mes );	// retorna o número de dias que tem o mês desejado
    $nome_mes = GetNomeMes( $mes );
    $diacorrente = 0;

    $diasemana = jddayofweek( cal_to_jd(CAL_GREGORIAN, $mes,"01",date('Y')) , 0 );	// função que descobre o dia da semana

    echo "<div class='row center container'><table id = 'tabela_mes' class='centered striped'>"; // TABELA PRINCIPAL ( TAG DE INICIO )
    echo "<tr id='tr_nome_mes'>";
    // echo "<td colspan = 7 id='td_nome_mes'>".$nome_mes."</td>"; // CABEÇALHO CALENDARIO ( NOME DO MES )
    echo "</tr>";
    echo "<tr class='tr_dias_semana'>";
    MostreSemanas();	// função que mostra as semanas aqui
    echo "</tr>";
    for( $linha = 0; $linha < 6; $linha++ )
    {


        echo "<tr class='tr_dia_mes'>";

        for( $coluna = 0; $coluna < 7; $coluna++ )
        {
            echo "<td ";

            if( ($diacorrente == ( date('d') - 1) && date('m') == $mes) )
            {
                echo " id = 'dia_atual' ";
            }
            else
            {
                if(($diacorrente + 1) <= $numero_dias )
                {
                    if( $coluna < $diasemana && $linha == 0)
                    {
                        echo " id = 'dia_branco' ";
                    }
                    else
                    {
                        echo " id = 'dia_comum' ";
                    }
                }
                else
                {
                    echo "id = 'dia vazio' style = 'display: none'";
                }
            }
            echo "class='td_dia_mes'>";


            /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO É MOSTRADO UM DIA DO CALENDÁRIO (MUITA ATENÇÃO NA HORA DA MANUTENÇÃO) */

            if( $diacorrente + 1 <= $numero_dias )
            {
                if( $coluna < $diasemana && $linha == 0)
                {
                    echo " ";
                }
                else
                {
                    echo "<a href = ".$_SERVER["PHP_SELF"]."?mes=$mes&dia=".($diacorrente+1)." id='link_dia_".($diacorrente+1)."' class='C_link_dia red-text'>".++$diacorrente . "</a>";
                }
            }
            else
            {
                break;
            }

            /* FIM DO TRECHO MUITO IMPORTANTE */



            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</table></div>";
}

function MostreCalendarioCompleto()
{
    echo "<table align = 'center'>";
    $cont = 1;
    for( $j = 0; $j < 4; $j++ )
    {
        echo "<tr>";
        for( $i = 0; $i < 3; $i++ )
        {

            echo "<td>";
            MostreCalendario( ($cont < 10 ) ? "0".$cont : $cont );

            $cont++;
            echo "</td>";

        }
        echo "</tr>";
    }
    echo "</table>";
}





?>