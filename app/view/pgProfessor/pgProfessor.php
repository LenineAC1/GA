<?php
$raiz = 'http://' . $_SERVER['HTTP_HOST'] . "/GA";


session_start();
if (!isset($_SESSION['session_login']) || $_SESSION['session_tipo'] != "professor") {
    $_SESSION['erro_login'] = 1;
    header("location: $raiz");
}
if (isset($_GET['id_lab'])) {
    $_SESSION['id_lab'] = $_GET['id_lab'];
} else {
}

?>

<!DOCTYPE html>

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
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0"/>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/tratamento_calendario.php';
    ?>
</head>

<style>
    header, main, footer {
        padding-left: 300px;
    }

    @media only screen and (max-width: 992px) {
        header, main, footer {
            padding-left: 0;
        }
    }
</style>

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

        <li><a class="modal-trigger" href="#modalNotf"><span class="new badge cyan darken-1"
                                                             data-badge-caption="nova(s)">1</span>NOTIFICAÇÕES</a></li>

        <li><a href="#cont?tipo=1&num=1">MEUS AGENDAMENTOS</a></li>

        <div class="divider"></div>

        <li class="center">LABORATÓRIOS</li>

        <ul class="collapsible">
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">computer</i>LABORATÓRIOS DE
                    INFORMÁTICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=1">LAB 1</a></li>
                        <li><a href="?id_lab=2">LAB 2</a></li>
                        <li><a href="?id_lab=3">LAB 3</a></li>
                        <li><a href="?id_lab=4">LAB 4</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="tiny material-icons">bubble_chart</i>LABORATÓRIOS
                    DE QUÍMICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=5">LAB 1</a></li>
                        <li><a href="?id_lab=6">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">restaurant</i>LABORATÓRIOS DE
                    NUTRIÇÃO E DIETÉTICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=7">LAB 1</a></li>
                        <li><a href="?id_lab=8">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper "><i class="material-icons">local_florist</i>LABORATÓRIOS
                    DE MEIO AMBIENTE
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=9">LAB 1</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <!--BOTÃO DE SAIR-->
        <div class="divider"></div>
        <li><a href="<?= $raiz ?>/libs/validacoes/login/validacao_deslog.php"><i
                        class="material-icons">close</i>SAIR</a></li>
    </ul>


    <!--calendario-->
    <div class="container">
        <div class="row center valign-wrapper">
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
                ?>
                </p>
                <?php if (!isset($_SESSION['id_lab'])) {
                    echo "Escolha um laboratorio!";
                } else {
                    echo getNomeLabByID($_SESSION['id_lab']);
                } ?>
            </div>
            <div class="col s2">
                <?php if (isset($_SESSION['id_lab'])) {
                    setas("dir");
                } ?>
            </div>
        </div>
    </div>
    <?php
    if (isset($_SESSION['id_lab'])) {
        MostreCalendario($view_mes_atual, $_SESSION['id_lab']);
    }
    ?>
</main>

<!-- Modal Notificações Structure -->
<div id="modalNotf" class="modal bottom-sheet">

    <div class="modal-content">
        <h4>Notificações</h4>
        <ul class="collection">

            <!--Estrutura da Notificação-->
            <li class="collection-item avatar">
                <span class="title">SOLICITAÇÃO ACEITA</span> <!--Estado da solicitação-->
                <p>Sua solicitação do: <span>nome lab</span>, <!--Nome do lab solicitado-->
                    para o dia: <span>data</span>, <!--data solicitada-->
                    foi <span>aceita</span>. <!--Estado da solicitação-->
                </p>
            </li>

        </ul>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">FINALIZAR</a>
    </div>
</div>

<!-- Modal Solicitação de laboratorio Structure -->
<div id="modalSolicitacao" class="modal modal-fixed-footer" style="min-height: 98%;">
    <form id="form_pedido" action="<?= $raiz . "/libs/validacoes/pedido/cadastro.php" ?>" method="post">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Solicitar</h4>
            Nome: <span><?php if (!isset($_SESSION['id_lab'])) {
                    echo "Escolha um laboratorio!";
                } else {
                    echo getNomeLabByID($_SESSION['id_lab']);
                } ?></span><br><!--Nome do lab solicitado-->
            Data: <span><?= sprintf("%02d", $_GET['dia']) ?? ''; ?>/<?= $_GET['mes'] ?? ''; ?></span>
            <!--Data solicitada-->
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header"><i class="cyan-text text-darken-1 material-icons">brightness_5</i>ETIM
                        / Ensino Médio
                    </div>
                    <div class="collapsible-body cyan-text text-darken-1">
                        <div class="row">
                            <div class="input-field col s6">
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
                            <div class="input-field col s6">
                                <select name="ano_manha" form="form_pedido" id="selec1_2">
                                    <option value="" selected>---</option>
                                    <option value="1º ano">1º ano</option>
                                    <option value="2º ano">2º ano</option>
                                    <option value="3º ano">3º ano</option>
                                </select>
                                <label>Selecione o Ano</label>
                            </div>
                            <div class="input-field col s6">
                                <select name="horario_manha" form="form_pedido" id="selec1_3">
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
<div id="modalErroPedido" class="modal">
    <div class="modal-content">
        <h4>Erro - Não foi possível realizar o pedido</h4>
        <p>Não conseguimos realizar seu pedido tente novamente mais tarde.
            Desculpe o incomodo.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>
<div id="modalExitoPedido" class="modal">
    <div class="modal-content">
        <h4>Exito - Seu pedido foi realizado com sucesso</h4>
        <p>A aprovação do seu pedido esta em analise, aguarde até a confimação.
        </p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
</div>
<footer>

</footer>

<!--JavaScript at end of body for optimized loading-->
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= $raiz ?>/libs/materialize/js/materialize.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
        $('select').formSelect();

        var sessao_lab = <?=$_SESSION['id_lab'] ?? '"nope"';?>;

        $('#modalSolicitacao').modal({
            endingTop: '1%',
            onOpenStart: function () {
                window.history.pushState("", "", window.location.href.replace(/&pedido/g, ''));
            }
        });

        if (window.location.href.indexOf("pedido") > -1 && sessao_lab !== "nope") {
            $('#modalSolicitacao').modal('open');
        }

        var sessao_pedido = '<?=$_SESSION['retorno_pedido'] ?? '"nope"';?>';

        $('#modalErroPedido').modal();
        $('#modalExitoPedido').modal();

        if (sessao_pedido == "erro") {
            $('#modalErroPedido').modal('open');
            sessao_pedido = null;
        } else if (sessao_pedido == "exito") {
            $('#modalExitoPedido').modal('open');
            sessao_pedido = null;
        }
    });

    $('#selec1_1,#selec1_2,#selec1_3').change(function () {
        if ($("#selec1_1 option:selected").text() !== "---" || $("#selec1_2 option:selected").text() !== "---" || $("#selec1_3 option:selected").text() !== "---") {

            $("#selec2_1,#selec2_2,#selec2_3").prop("disabled", true);
            $('select').formSelect();

        } else {
            $("#selec2_1,#selec2_2,#selec2_3").prop("disabled", false);
            $('select').formSelect();
        }
        if ($("#selec1_1 option:selected").text() == "Segurança do trabalho") {
            $('#selec1_2 option[value="1º ano"]').prop("disabled", true);
            $('select').formSelect();
        }

        if ($("#selec1_1 option:selected").text() !== "---" && $("#selec1_2 option:selected").text() !== "---" && $("#selec1_3 option:selected").text() !== "---") {

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

</script>
<?php if (isset($_SESSION['retorno_pedido'])) {
    unset($_SESSION['retorno_pedido']);
} ?>
</body>
</html>

