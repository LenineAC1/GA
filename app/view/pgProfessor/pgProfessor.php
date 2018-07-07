<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";


session_start();
if(!isset($_SESSION['session_login']) || $_SESSION['session_tipo'] != "professor"){
    $_SESSION['erro_login'] = 1;
    header("location: $raiz");
}
if (isset($_GET['id_lab'])){
    $_SESSION['id_lab'] = $_GET['id_lab'];
}else{
}


?>

<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?=$raiz?>/libs/materialize/css/materialize.css"  media="screen,projection"/>
    <!--Import custom.css-->
    <link type="text/css" rel="stylesheet" href="<?=$raiz?>/libs/materialize/css/custom.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0"/>

    <?php
    require_once $_SERVER['DOCUMENT_ROOT']. '/GA/libs/funcoes_php/tratamento_calendario.php';
    ?>
</head>

<style>
    header, main, footer {
        padding-left: 300px;
    }

    @media only screen and (max-width : 992px) {
        header, main, footer {
            padding-left: 0;
        }
    }
</style>

<body>

<nav class="hide-on-large-only red darken-3">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo center"><img src="<?=$raiz?>/app/view/_img/logoGA.png" style="height: 30px;"></a>
        <ul id="nav-mobile" class="left">
            <li><a href="#" data-target="slide-out" class="show-on-large sidenav-trigger white-text"><i class="small material-icons">menu</i></a></li>
        </ul>
    </div>
</nav>

<main>

    <ul id="slide-out" class="sidenav sidenav-fixed">
        <li class="center red darken-3">
            <a href="#"><img src="<?=$raiz?>/app/view/_img/logoGA.png" style="height: 50px;"></a>
        </li>
        <!-- Modal Notificações Trigger // Alterar o número de novas notificações-->
        <li><a class="modal-trigger" href="#modalNotf"><span class="new badge red darken-3" data-badge-caption="nova(s)">1</span>NOTIFICAÇÕES</a></li>

        <li><a href="#cont?tipo=1&num=1">MEUS AGENDAMENTOS</a></li>

        <div class="divider"></div>

        <li class="center">LABORATÓRIOS</li>

        <ul class="collapsible">
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">computer</i>LABORATÓRIOS DE INFORMÁTICA</div>
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
                <div class="collapsible-header valign-wrapper"><i class="tiny material-icons">bubble_chart</i>LABORATÓRIOS DE QUÍMICA</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=5">LAB 1</a></li>
                        <li><a href="?id_lab=6">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">restaurant</i>LABORATÓRIOS DE NUTRIÇÃO E DIETÉTICA</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=7">LAB 1</a></li>
                        <li><a href="?id_lab=8">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper "><i class="material-icons">local_florist</i>LABORATÓRIOS DE MEIO AMBIENTE</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=9">LAB 1</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <!--BOTÃO DE SAIR-->
        <div class="divider"></div>
        <li><a href="<?=$raiz?>/libs/validacoes/login/validacao_deslog.php"><i class="material-icons">close</i>SAIR</a></li>
    </ul>
    <div class="row center">
        <div class="col s12">
            <p class="flow-text">Calendário</p>
            <?php if (!isset($_SESSION['id_lab'])){echo "Escolha um laboratorio !";}else{echo getNomeLabByID($_SESSION['id_lab']);}?>
            <p class="flow-text"><?php echo GetNomeMes($view_mes_atual)." - ".date("Y")?></p>
        </div>
    </div>
    <div class="container">
        <a href=?atual=menos><i class="medium material-icons red-text">chevron_left</i></a>
        <a href=?atual=mais style="float: right"><i class="medium material-icons red-text">chevron_right</i></a>
    </div>
    <?php MostreCalendario($view_mes_atual,$_SESSION['id_lab']) ?>

</main>

<footer>

</footer>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/materialize.min.js"></script>
<script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/jscustom.js"></script>
<script type="text/javascript" src="<?=$raiz?>/libs/jquery.js"></script>
<script>
    var url_atual = window.location.href;

    if(url_atual.indexOf('atual=mais') != -1){
        window.history.pushState(null, null, url_atual.replace('?atual=mais',''));
    }else if(url_atual.indexOf('atual=menos') != -1){
        window.history.pushState(null, null, url_atual.replace('?atual=menos',''));
    }

</script>
</body>
</html>