<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/tratamento_calendario.php';
if (session_id() == '') {
    session_start();
}
if(!isset($_SESSION['session_login']) || $_SESSION['session_tipo'] != "admin"){
    $_SESSION['erro_login'] = 1;
    header("location: $raiz");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="bodyCoord" style="background-color: #f4f4f4">

<nav class="hide-on-large-only red darken-3">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo center"><img src="<?=$raiz?>/app/view/_img/logoGA.png" style="height: 30px;"></a>
        <ul id="nav-mobile" class="left">
            <li><a href="#" data-target="slide-out" class="sidenav-trigger white-text"><i class="small material-icons">menu</i></a></li>
        </ul>
    </div>
</nav>
<main>
<ul id="slide-out" class="sidenav sidenav-fixed">
    <li class="center red darken-3">
        <a href="#"><img src="<?=$raiz?>/app/view/_img/logoGA.png" style="height: 50px;"></a>
    </li>
    <li class="center">Controle de usuarios</li>
    <li><a href="" id="" class="mudarOpc">CADASTRO DE USUARIOS</a></li>
    <li><a href="" id="" class="mudarOpc">GERENCIAMENTO DE USUARIOS</a></li>
    <div class="divider"></div>
    <li class="center">Reclamações e BUGS</li>
    <li><a href="" id="" class="mudarOpc">RECLAMAÇÕES DE USO</a></li>
    <li><a href="" id="" class="mudarOpc">BUGS REPORTADOS</a></li>
    <!--BOTÃO DE SAIR-->
    <div class="divider"></div>
    <li><a href="<?= $raiz ?>/libs/validacoes/login/validacao_deslog.php"><i class="material-icons">close</i>SAIR</a></li>
</ul>

    <div class="row fundo-row">
        <div class="col s12 fundo-row2" style="padding: 1% 2%">
            <div class="col s12 white z-depth-1 fundo-row3" style="padding: 0 2%">
                <?php
                echo "
                        <div id='ModalCadastro' style='height: 80%; font-size: 85%'>
              <div class='modal-content center'>
                  <h4 class='cyan-text text-darken-1 h4Coord' style='margin: 4% auto 4% auto'>Cadastro de usuarios</h4>
                  <div class='row'>
                      <form action='$raiz/libs/validacoes/ControleUsuario/cadastro.php' method='post' name='formCad' class='col s12'>
                          <div class='row'>

                                  <div class='input-field col s12'>
                                      <input name='email' id='email' type='email' class='validate'>
                                      <label for='email'>Email</label>
                                  </div>

                              <div class='input-field col s6'>
                                  <input name='primeiro_nome' id='primeiro_nome' type='text' class='validate'>
                                  <label for='primeiro_nome'>Primeiro Nome</label>
                              </div>
                              <div class='input-field col s6'>
                                  <input name='sobrenome' id='sobrenome' type='text' class='validate'>
                                  <label for='sobrenome'>Sobrenome</label>
                              </div>
                              <div class='input-field col s12'>
                                  <select name='opcTipo'>
                                      <option value='' disabled selected>Escolha sua opção</option>
                                      <option value='1'>Professor</option>
                                      <option value='2'>Coordenador</option>
                                  </select>
                                  <label>Tipo de usuario</label>
                              </div>
                              <button class='btn waves-effect waves-light btn-large cyan darken-2' type='submit'>Submit
                                  <i class='material-icons right'>send</i>
                              </button>
                          </div>


                      </form>
                  </div>
              </div>
              </div>
                     ";
                ?>

            </div>
        </div>
    </div>

    <footer>

    </footer>
    <div id="modalExitoCadastro" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Exito - usuario foi cadastrado com sucesso</h4>
            <p>Tudo sob controle a senha é: <?= $_SESSION['firstSenha']?>
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <div id="modalErroCadastro" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Erro - O usuario não foi cadastrado</h4>
            <p>Algo deu errado, faça um verificação no sistema.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>
</main>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/materialize.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
            $('.sidenav').sidenav();
            $('.collapsible').collapsible();
            $('.modal').modal();
            $('select').formSelect();

        var sessao_cadastro = '<?=$_SESSION['retorno_cadastro'] ?? '"nope"';?>';

        $('#modalCadastro').modal();

        if (sessao_cadastro == "erro") {
            $('#modalErroCadastro').modal('open');
            sessao_update = null;
        } else if (sessao_cadastro == "exito") {
            $('#modalExitoCadastro').modal('open');
            sessao_update = null;
        }

        });
    </script>
</body>
</html>
<?php if (isset($_SESSION['retorno_cadastro'])) {
    unset($_SESSION['retorno_cadastro']);
} ?>