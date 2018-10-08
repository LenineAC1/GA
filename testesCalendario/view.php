
<?php
/**
 * Created by PhpStorm.
 * User: Le9
 * Date: 29/09/2018
 * Time: 15:25
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';
require_once 'Calendario.php';
$raiz = 'http://' . $_SERVER['HTTP_HOST'] . "/GA";
$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

if (session_id() == '') {
    session_start();
}
$_SESSION['id_lab'] = 1;

?>

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

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?= $raiz ?>/libs/materialize/js/materialize.js"></script>

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
<div class='row center container'>

    <?php
    if (isset($_SESSION['id_lab'])) {
        MostreCalendario($view_mes_atual, $_SESSION['id_lab']);
    }
    ?>
</div>
