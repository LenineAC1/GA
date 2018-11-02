<?php
$raiz = 'http://' . $_SERVER['HTTP_HOST'] . "/GA";

require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/tratamento_calendario.php';

$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

if (session_id() == '') {
    session_start();
}
if (!isset($_SESSION['session_login']) || $_SESSION['session_tipo'] != "professor") {
    $_SESSION['erro_login'] = 1;
    header("location: $raiz");
} //so continua na pagina se estiver logado

if (isset($_GET['id_lab'])) {
    $_SESSION['id_lab'] = $_GET['id_lab'];
}


$disponivel = array(
    1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => '', 7 => '', 8 => '', 9 => ''
); // aulas disponives

if (isset($_SESSION['id_lab']) && isset($_GET['mes']) && isset($_GET['dia'])) {


    $dataCompleta = dataCompletaPTBR($_GET['dia'], $_GET['mes'], null);
    $query_select_disponivel = $conexao_pdo->prepare("SELECT HORARIO FROM `agendamento` WHERE `DATA` = :dataAgendamento AND `FK_O_A_ID` = :idLab"); //prepara a query de seleção onde as informações são correspondentes
    $query_select_disponivel->bindParam(':dataAgendamento', $dataCompleta);
    $query_select_disponivel->bindParam(':idLab', $_SESSION['id_lab']);

    if ($query_select_disponivel->execute()) {
        $queryResult = $query_select_disponivel->fetchAll(PDO::FETCH_COLUMN, 0); // passa resultado da query para um array
        if (count($queryResult) >= 1) {
            $queryResult = implode(",",$queryResult);
            $queryResult = explode(",",$queryResult);
            $queryResult = array_unique($queryResult);
            foreach ($queryResult as $array => $key) {

                $disponivel[$key] = "disabled";
            }
        }

    }
}//define oque sera disabilitado na escolha de pedido

$arrayAgendamentos = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta


//$arrayAgendamentos_Notifi2 = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta


?>

<!DOCTYPE html>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?= $raiz ?>/libs/materialize/js/materialize.js"></script>
<script>
    $.ajax({
        type: "GET",
        url: "../../../libs/funcoes_php/autoUpdateNotf.php",
        data: "name=a",
        dataType: 'json',
        success: function (data) {
            $(".result").html(data[0]);
            $(".notf").html(data[1]);
        }
    });
</script>
<html>
<head>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?= $raiz ?>/libs/materialize/css/materialize.css"
          media="screen,projection"/>
    <!--Import custom.css-->
    <link type="text/css" rel="stylesheet" href="<?= $raiz ?>/libs/materialize/css/custom.css"
          media="screen,projection"/>


    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>
<body>

<nav class="hide-on-large-only red darken-3">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo center"><img src="<?= $raiz ?>/app/view/_img/logoGA.png"
                                                   style="height: 30px;"></a>
        <ul id="nav-mobile" class="left">
            <li><a href="#" data-target="slide-out" class="show-on-large sidenav-trigger white-text"><i
                            class="small material-icons">menu</i></a></li>
        </ul>
    </div>
</nav>

<main>

    <ul id="slide-out" class="sidenav sidenav-fixed">
        <li class="center red darken-3">
            <a href="#"><img src="<?= $raiz ?>/app/view/_img/logoGA.png" style="height: 50px;"></a>
        </li>
        <!-- Modal Notificações Trigger // Alterar o número de novas notificações-->



        <li><a class="modal-trigger" href="#modalNotf"><span class="new badge cyan darken-1 notf"
                                                             data-badge-caption="nova(s)"></span>NOTIFICAÇÕES</a></li>




        <li><a href="#modalMeusAgendamentos" class="modal-trigger" id="abrirAgendamentos">MEUS AGENDAMENTOS</a></li>


        <!--BOTÃO DE SAIR-->
        <div class="divider"></div>
        <li><a href="<?= $raiz ?>/libs/validacoes/login/validacao_deslog.php"><i
                        class="material-icons">close</i>SAIR</a></li>
    </ul>

    <!--calendario-->

    <div class="row center container">
        <!--Labs card-->
            <h5>Escolha um laboratório!</h5>
            <?php require '../profLabs.html'; ?>
        <!--FIM Labs card-->
    </div>

    <div class="divider"></div>

    <div class="container">
        <div id="cal" class="row center valign-wrapper">

            <div class="col s2">
                <?php if (isset($_SESSION['id_lab'])) {
                    setas("esq");
                } ?>
            </div>
            <div class="col s8">
                <?php
                if (isset($_SESSION['id_lab'])) {
                    echo "<p class='flow-text' > Selecione uma data <br>";
                    echo GetNomeMes($view_mes_atual) . " - " . date("Y");
                }

                echo "</p>";
                ?>
                <?php if (!isset($_SESSION['id_lab'])) {
                    echo "<h5>Escolha um laboratório!</h5>";

                } else {
                    echo "<ul class='collapsible popout' data-collapsible='accordion'>
                    <li>
                    ";
                    echo "<div class='collapsible-header center' style='display: block; font-size: 1.1vw'>".getNomeLabByID($_SESSION['id_lab'])."</div>";
                    echo "<div class='collapsible-body' style='text-align: justify'>Condição de uso geral: ".getCondicaoFraseFeed(calcularMediaFeed($_SESSION['id_lab']))." <br><br>".getDescricaoByID($_SESSION['id_lab'])."</div>";
                    echo "</li></ul>";
                } ?>
            </div>
            <div class="col s2">
                <?php if (isset($_SESSION['id_lab'])) {
                    setas("dir");
                } ?>
            </div>
        </div>
    </div>


    <div class='row center container'>

        <?php
        if (isset($_SESSION['id_lab'])) {
            MostreCalendario($view_mes_atual, $_SESSION['id_lab']);
        }
    ?>
    </div>


</main>

<!-- Modal Notificações Structure -->
<div id="modalNotf" class="modal bottom-sheet">


    <div class="modal-content">
        <h4>Notificações</h4>
        <ul class="collection">
            <div class="result">

            </div>
        </ul>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">FINALIZAR</a>
    </div>
</div>

<!-- Modal Solicitação de laboratorio Structure -->
<div id="modalSolicitacao" class="modal modal-fixed-footer" style="min-height: 98%;">
    <form id="form_pedido" action="<?= $raiz . "/libs/validacoes/agendamento/cadastro.php" ?>" method="post">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Solicitar agendamento</h4>
            Nome: <span><?php if (!isset($_SESSION['id_lab'])) {
                    echo "Escolha um laboratorio!";
                } else {
                    echo getNomeLabByID($_SESSION['id_lab']);
                } ?></span><br><!--Nome do lab solicitado-->
            Data: <span><?= dataCompletaPTBR($_GET['dia'], $_GET['mes'], "/"); ?></span>
            <!--Data solicitada-->
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="cyan-text text-darken-1 material-icons">brightness_5</i>ETIM
                        / Ensino Médio
                    </div>
                    <div class="collapsible-body cyan-text text-darken-1">
                        <div class="row">
                            <div class="input-field col s12">
                                <select name="curso_manha" form="form_pedido" id="selec1_1">
                                    <option value="" selected>---</option>
                                    <option value="Ensino Médio">Ensino Médio</option>
                                    <option value="Informática">Informática</option>
                                    <option value="Química">Química</option>
                                    <option value="Segurança do trabalho">Segurança do trabalho</option>
                                    <option value="Nutrição e Dietética">Nutrição e Dietética</option>
                                    <option value="Meio Ambiente">Meio Ambiente</option>
                                </select>
                                <label>Selecione um Curso</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select name="ano_manha" form="form_pedido" id="selec1_2">
                                    <option value="" selected>---</option>
                                    <option value="1º ano">1º ano</option>
                                    <option value="2º ano">2º ano</option>
                                    <option value="3º ano">3º ano</option>
                                </select>
                                <label>Selecione o Ano</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <select multiple name="horario_manha[]" form="form_pedido" id="selec1_3">
                                    <option value="" disabled selected>---</option>
                                    <option value="1" <?= $disponivel[1] ?? ''; ?>>1º Aula</option>
                                    <option value="2" <?= $disponivel[2] ?? ''; ?>>2º Aula</option>
                                    <option value="3" <?= $disponivel[3] ?? ''; ?>>3º Aula</option>
                                    <option value="4" <?= $disponivel[4] ?? ''; ?>>4º Aula</option>
                                    <option value="5" <?= $disponivel[5] ?? ''; ?>>5º Aula</option>
                                    <option value="6" <?= $disponivel[6] ?? ''; ?>>6º Aula</option>
                                    <option value="7" <?= $disponivel[7] ?? ''; ?>>7º Aula</option>
                                    <option value="8" <?= $disponivel[8] ?? ''; ?>>8º Aula</option>
                                    <option value="9" <?= $disponivel[9] ?? ''; ?>>9º Aula</option>
                                </select>
                                <label>Selecione o horário</label>
                            </div>
                        </div>
                    </div>
                </li>
                <!--<li>
                  <div class="collapsible-header"><i class="cyan-text text-darken-1 material-icons">brightness_2</i>Modular</div>
                  <div class="collapsible-body cyan-text text-darken-1">
                    <div class="row">
                      <div class="input-field col s6">
                        <select name="curso_noite" form="form_pedido" id="selec2_1">
                          <option value="" selected>---</option>
                          <option value="Informática">Informática</option>
                          <option value="Automação Industrial">Automação Industrial</option>
                          <option value="Contabilidade">Contabilidade</option>
                          <option value="Segurança do trabalho">Segurança do trabalho</option>
                          <option value="Nutrição e Dietética">Nutrição e Dietética</option>
                          <option value="Química">Química</option>
                        </select>
                        <label>Selecione um Curso</label>
                      </div>
                      <div class="input-field col s6">
                        <select name="ano_noite" form="form_pedido" id="selec2_2">
                          <option value="" selected>---</option>
                          <option value="1º módulo">1º módulo</option>
                          <option value="2º módulo">2º módulo</option>
                          <option value="3º módulo">3º módulo</option>
                        </select>
                        <label>Selecione o Ano</label>
                      </div>
                        <div class="input-field col s6">
                            <select name="horario_noite" form="form_pedido" id="selec2_3">
                                <option value="" selected>---</option>
                                <option value="1">1º Aula - 7:00 até 7:50</option>
                                <option value="2">2º Aula - 7:50 até 8:40</option>
                                <option value="3">3º Aula - 8:40 até 9:30</option>
                                <option value="1">4º Aula - 9:50 até 10:40</option>
                                <option value="2">5º Aula - 10:40 até 11:30</option>
                                <option value="3">6º Aula - 11:30 até 12:20</option>
                                <option value="1">7º Aula - 13:30 até 14:20</option>
                                <option value="2">8º Aula - 14:20 até 15:10</option>
                                <option value="3">9º Aula - 15:10 até 15:50</option>
                            </select>
                            <label>Selecione o horário</label>
                        </div>
                    </div>
                  </div>
                </li>-->
            </ul>
        </div>
        <div class="modal-footer">
            <button type="submit" value="SOLICITAR AGENDAMENTO"
                    class="modal-close waves-effect waves-green btn-flat disabled" id="submit_pedido">SOLICITAR
                AGENDAMENTO
            </button>
            <a href="#!" class="modal-close waves-effect waves-red btn-flat">CANCELAR</a>
        </div>
        <input type="hidden" value="<?= $_GET['mes'] ?? ''; ?>" name="mes_agendamento">
        <input type="hidden" value="<?= $_GET['dia'] ?? ''; ?>" name="dia_agendamento">
        <input type="hidden" value="<?= $_SESSION['id_lab'] ?? ''; ?>" name="lab_agendamento">
        <input type="hidden" value="<?= $_SESSION['session_login_id'] ?? ''; ?>" name="id_conta_agendamento">
    </form>
</div>

<!-- Modal erro Solicitação Structure -->
<div id="modalErroPedido" class="modal retorno">
    <div class="modal-content">
        <h4 class="cyan-text text-darken-1">Erro - Não foi possível realizar o pedido</h4>
        <p>Não conseguimos realizar seu pedido tente novamente mais tarde.
            Desculpe o incomodo.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<!-- Modal exito Solicitação Structure -->
<div id="modalExitoPedido" class="modal retorno">
    <div class="modal-content">
        <h4 class="cyan-text text-darken-1">Exito - Seu pedido foi realizado com sucesso</h4>
        <p>A aprovação do seu pedido esta em analise, aguarde até a confimação.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<!-- Modal erro FEEDBACK Structure -->
<div id="modalErroFeedback" class="modal retorno">
    <div class="modal-content">
        <h4 class="cyan-text text-darken-1">Erro - Não foi possível enviar seu feeback</h4>
        <p>Não conseguimos realizar seu pedido tente novamente mais tarde.
            Desculpe o incomodo.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<!-- Modal exito FEEDBACK Structure -->
<div id="modalExitoFeedback" class="modal retorno">
    <div class="modal-content">
        <h4 class="cyan-text text-darken-1">Exito - Seu feedback foi enviado com sucesso</h4>
        <p>Seu feedback foi enviado para a coordenação, obrigado por sua ajuda.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>


<!-- Modal meus agendamentos Structure -->
<div id="modalMeusAgendamentos" class="modal" style="width:100% !important; height: 85%;">
    <div class="modal-content">
        <h4 class="cyan-text text-darken-1" style="margin: 3% auto 3% auto">Meus agendamentos</h4>

        <table class="centered responsive-table bordered">

            <thead>
            <tr>
                <th>Data</th>
                <th>Horario</th>
                <th>Laboratorio</th>
                <th>Ano</th>
                <th>Curso</th>
                <th>Estado</th>
                <th>Feedback</th>
            </tr>
            </thead>

            <tbody>

            <?php
            foreach ($arrayAgendamentos as $arrayAgendamentos) {
                // checa se o agendamento ja passou da data atual

                $dataAgendamento = substr($arrayAgendamentos['DATA'], 4, 4)."-". substr($arrayAgendamentos['DATA'], 2, 2) . "-" . substr($arrayAgendamentos['DATA'],0,2);
                $timestamp_dt 	= strtotime($dataAgendamento); // converte para timestamp Unix
                $timestamp_dt_expira	= strtotime(date("Y-m-d"));
                if ($timestamp_dt < $timestamp_dt_expira){
                }else {
                    if($arrayAgendamentos['ESTADO_AGENDAMENTO'] != 'em analise' && $arrayAgendamentos['ESTADO_AGENDAMENTO'] != 'negado' && !getFeedbackByID($arrayAgendamentos['ID'])) {
                        echo "<tr data-url=?idAgenFeed=" . $arrayAgendamentos['ID'] . " class='trAgenFeed'>";
                    }else{
                        echo "<tr>";
                    }
                    echo "<td>".substr($arrayAgendamentos['DATA'], 0, 2) . "/" . substr($arrayAgendamentos['DATA'], 2, 2) . "/" . substr($arrayAgendamentos['DATA'], 4, 4) . "</td>";
                    echo "<td>" . getHorarioByID($arrayAgendamentos['HORARIO']) . "</td>";
                    echo "<td>" . getNomeLabByID($arrayAgendamentos['FK_O_A_ID']) . "</td>";
                    echo "<td>" . $arrayAgendamentos['ANO_CURSO'] . "</td>";
                    echo "<td>" . $arrayAgendamentos['CURSO'] . "</td>";
                    if ($arrayAgendamentos['ESTADO_AGENDAMENTO'] == "confirmado") {
                        echo "<td><i class='small material-icons green-text text-darken-2'>check</i></td>";
                    } else if ($arrayAgendamentos['ESTADO_AGENDAMENTO'] == "negado") {
                        echo "<td><i class='small material-icons red-text text-darken-2'>clear</i></td>";
                    } else {
                        echo "<td><i class='small material-icons yellow-text text-darken-1'>cached</i></td>";
                    }
                    if($arrayAgendamentos['ESTADO_AGENDAMENTO'] != 'em analise' && $arrayAgendamentos['ESTADO_AGENDAMENTO'] != 'negado'  && !getFeedbackByID($arrayAgendamentos['ID'])) {
                        echo '<td><i class="small material-icons cyan-text text-darken-1"><a class="waves-effect waves-light abrir-feed" id='.$arrayAgendamentos['ID'].'>feedback</a></i></td>';
                    }else{
                        echo '<td><i class="small material-icons grey-text text-lighten-2">feedback</i></td>';
                    }
                    echo "</tr>";
                }
            }
            ?>

            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>

<!-- Estrutura modal feedback -->
<div id="modalFeedback" class="modal">
    <form id="form_feedback" action="<?= $raiz . "/libs/validacoes/agendamento/feedback.php" ?>" method="post">
    <div class="modal-content">
        <h4 class="cyan-text text-darken-1" style="margin: 3% auto 3% auto">Feedback de uso</h4>
        <div class="divider"></div>
        <div class="section">
            <div class="row">
            <div class="input-field col s12">
                <select name="select_feedback" form="form_feedback">
                    <option value="nulo" selected>---</option>
                    <option value="1">Ótimo, sem problemas durante o uso.</option>
                    <option value="2" >Mediano, alguns componentes estavam comprometidos.</option>
                    <option value="3">Ruim, o uso foi afetado negativamente.</option>
                </select>
                <label>Condição de uso do laboratório(Opcional)</label>
            </div>
        </div>
        </div>
            <div class="input-field col s12">
                <textarea id="textarea_feedback" class="materialize-textarea" name="textarea_feedback" form="form_feedback"></textarea>
                <label for="textarea_feedback">Escreva seu feedback de uso</label>
            </div>
        </div>

        <?php
        $agendamentoFeedback = getAgendamentoByID($_SESSION['idAgenFeed']);
        ?>
    <div class="modal-footer">
        <button type="submit" class="modal-close waves-effect waves-green btn-flat disabled" id="submit_feedback">Enviar feedback
        </button>
    </div>
        <?PHP
        $ID_LAB = getAgendamentoByID($agendamentoFeedback['ID']);
        ?>
        <input type="hidden" value="<?= $_SESSION['session_login_id'] ?? ''; ?>" name="id_conta_feedback">
        <input type="hidden" value="<?= $agendamentoFeedback['ID'] ?? ''; ?>" name="id_agendamento_feedback">
        <input type="hidden" value="<?= $ID_LAB['FK_O_A_ID'] ?? ''; ?>" name="id_lab_feedback">
    </form>
    </div>


<footer>
    <?php

    if (isset($_GET['dia']) && isset($_GET['mes'])) {
        $dataEscolhidaCompleta = dataCompletaPTBR($_GET['dia'], $_GET['mes'], "/");
        foreach ($_SESSION['datasProibidas'] as $key => $value) {
            if ($value == $dataEscolhidaCompleta) {//checa se a a data escolhida é valida para agendamento
                $_SESSION['PERMISSAOPEDIDO'] = "negado";
                break;
            } else {
                $_SESSION['PERMISSAOPEDIDO'] = "permitido";
            }
        }
    }else{
        $_SESSION['PERMISSAOPEDIDO'] = "negado";
    }

    ?>
</footer>
<!--JavaScript at end of body for optimized loading-->


<script type="text/javascript">

    $(document).ready(function () {
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
        $('.modal').modal();
        $('select').formSelect();
        $('textarea').characterCounter();



        //TODA ESSA BAGUNÇA VAI SER PASSADO PRA UM UNICO ARQUIVO PRA FICAR MAIS LIMPO





        var sessao_lab = <?=$_SESSION['id_lab'] ?? '"nope"';?>;
        var permissao_dia = "<?=$_SESSION['PERMISSAOPEDIDO'] ?? 'negado';?>";
        var sessao_feed = "<?=$_SESSION['idAgenFeed'] ?? 'nope';?>";
        var ids = 0;
        var updateperm = "no";


        $('#modalSolicitacao').modal({
            //endingTop: '1%',
            onOpenStart: function () {
                window.history.pushState("", "", window.location.href.replace(/&pedido/g, ''));
            }
        });





        if (window.location.href.indexOf("pedido") > -1 && sessao_lab !== "nope" && permissao_dia == "permitido") {
            $('#modalSolicitacao').modal('open');
        }

        var sessao_pedido = '<?=$_SESSION['retorno_pedido'] ?? '"nope"';?>';
        var sessao_retorno_feed = "<?=$_SESSION['retorno_feedback'] ?? 'nope';?>";

        $('#modalErroPedido').modal();
        $('#modalExitoPedido').modal();
        $('#modalExitoFeedback').modal();
        $('#modalErroFeedback').modal();
        $('.abrir-feed').click(function () {

            $.ajax({
                url: "../../../libs/funcoes_php/setsessionFeedback.php",
                type: 'POST', //I want a type as POST
                data: "name="+$(this).attr('id'),
                success: function(data){
                    location.reload();
                }
            });
        });

                setInterval(function () {
                    ids = $(".agendNotf").map(function () {
                        return this.id;
                    }).get();
                    $.ajax({
                        type: "GET",
                        url: "../../../libs/funcoes_php/autoUpdateNotf.php",
                        data: "name=a",
                        dataType: 'json',
                        success: function (data) {
                            $(".result").html(data[0]);
                            $(".notf").html(data[1]);
                            if (data[2]=="pulse"){
                                $(".notf").addClass('pulse');
                            }else{
                                $(".notf").removeClass("pulse");
                            }
                        }
                    });
                }, 500);



        if (sessao_pedido == "erro") {
            $('#modalErroPedido').modal('open');
            sessao_pedido = null;
        }
        else if (sessao_pedido == "exito") {
            $('#modalExitoPedido').modal('open');
            sessao_pedido = null;
        }

        if (sessao_retorno_feed == "erro") {
            $('#modalErroFeedback').modal('open');
            sessao_retorno_feed = null;
        }
        else if (sessao_retorno_feed == "exito") {
            $('#modalExitoFeedback').modal('open');
            sessao_retorno_feed = null;
        }

        if (sessao_feed != "nope"){
            $('#modalFeedback').modal('open');
        }
        $('#modalNotf').modal({
            //endingTop: '1%',
            onCloseEnd: function () {
                $.ajax({
                    url: "../../../libs/funcoes_php/UpdateNotficacaoProf.php",
                    type: 'POST', //I want a type as POST
                    data: "idsLab="+ids,
                    success: function(data){

                    }
                });
            }
        });


    });



    //--------------Valida se posso ou nao enviar pedido-------------//
    $('#selec1_1,#selec1_2,#selec1_3').change(function () {

        if ($("#selec1_1 option:selected").text() !== "---" || $("#selec1_2 option:selected").text() !== "---" || $("#selec1_3 option:selected").length > 0) {

            $("#selec2_1,#selec2_2,#selec2_3").prop("disabled", true);
            $('select').formSelect();

        } else {
            $("#selec2_1,#selec2_2,#selec2_3").prop("disabled", false);
            $('select').formSelect();
        }
        if ($("#selec1_1 option:selected").text() == "Segurança do trabalho") {
            $('#selec1_2 option[value="1º ano"]').prop("selected", false);
            $('#selec1_2 option[value="1º ano"]').prop("disabled", true);

            $('select').formSelect();
        }else{
            $('#selec1_2 option[value="1º ano"]').prop("disabled", false);
            $('select').formSelect();
        }

        if ($("#selec1_1 option:selected").text() !== "---" && $("#selec1_2 option:selected").text() !== "---" &&  $("#selec1_3 option:selected").length > 0) {

            $('#submit_pedido').removeClass("disabled");
            $('select').formSelect();

        } else {
            $('#submit_pedido').addClass("disabled");
            $('select').formSelect();
        }

    });

    $('#selec2_1,#selec2_2,#selec2_3').change(function () {
        if ($("#selec2_1 option:selected").text() !== "---" || $("#selec2_2 option:selected").text() !== "---" || $("#selec2_3 option:selected").text() !== "---") {

            $("#selec1_1,#selec1_2,#selec1_3").prop("disabled", true);
            $('select').formSelect();

        } else {
            $("#selec1_1,#selec1_2,#selec1_3").prop("disabled", false);
            $('select').formSelect();
        }

        if ($("#selec2_1 option:selected").text() !== "---" && $("#selec2_2 option:selected").text() !== "---" && $("#selec2_3 option:selected").text() !== "---") {

            $('#submit_pedido').removeClass("disabled");
            $('select').formSelect();

        } else {
            $('#submit_pedido').addClass("disabled");
            $('select').formSelect();
        }
    });
    //---------------------------------------------------------------//
    //--------------Valida se posso ou nao enviar pedido-------------//
    $('#textarea_feedback').bind('input propertychange',function () {
        if ($('#textarea_feedback').val().length > 0){
            $('#submit_feedback').removeClass("disabled");
        }else{
            $('#submit_feedback').addClass("disabled");
        }
    });

    // ---------------------------------------------------------------//
</script>
<?php
if (isset($_SESSION['retorno_pedido'])) {
    unset($_SESSION['retorno_pedido']);
}
if(isset($_SESSION['retorno_feedback'])){
    unset($_SESSION['retorno_feedback']);
}
if (isset($_SESSION['idAgenFeed'])) {
    unset($_SESSION['idAgenFeed']);
}
?>
</body>
</html>

