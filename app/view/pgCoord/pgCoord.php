<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";

    session_start();
    if(!$_SESSION['session_login'] || $_SESSION['session_tipo'] != "coordenador"){
        header("location: $raiz/index.php?error=1");
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
        <a href="#" class="brand-logo center"><img src="../_img/logoGA.png" style="height: 30px;"></a>
        <ul id="nav-mobile" class="left">
          <li><a href="#" data-target="slide-out" class="sidenav-trigger white-text"><i class="small material-icons">menu</i></a></li>
        </ul>
      </div>
    </nav>
        
    <main>
      
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li class="center red darken-3">
          <a href="#"><img src="../_img/logoGA.png" style="height: 15px;"></a>
      </li>
      <!-- Modal Notificações Trigger // Alterar o número de novas notificações-->
      <li><a class="modal-trigger" href="#modalNotf"><span class="new badge red darken-3">1</span>NOTIFICAÇÕES</a></li>

      <div class="divider"></div>

      <li><a href="#cont?tipo=1&num=1">HISTÓRICO DE AGENDAMENTOS</a></li>

      <ul class="collapsible">
        <div class="divider"></div>
        <li>
          <div class="collapsible-header valign-wrapper"><i class="material-icons">computer</i>LABORATÓRIOS DE INFORMÁTICA</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=1&num=1">LAB 1</a></li>
              <li><a href="#cont?tipo=1&num=2">LAB 2</a></li>
              <li><a href="#cont?tipo=1&num=3">LAB 3</a></li>
              <li><a href="#cont?tipo=1&num=4">LAB 4</a></li>
            </ul>
          </div>
        </li>
        <div class="divider"></div>
        <li>
          <div class="collapsible-header valign-wrapper"><i class="tiny material-icons">bubble_chart</i>LABORATÓRIOS DE QUÍMICA</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=2&num=1">LAB 1</a></li>
              <li><a href="#cont?tipo=2&num=2">LAB 2</a></li>
            </ul>
          </div>
        </li>
        <div class="divider"></div>
        <li>
          <div class="collapsible-header valign-wrapper"><i class="material-icons">restaurant</i>LABORATÓRIOS DE NUTRIÇÃO E DIETÉTICA</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=3&num=1">LAB 1</a></li>
              <li><a href="#cont?tipo=3&num=2">LAB 2</a></li>
            </ul>
          </div>
        </li>
        <div class="divider"></div>
        <li>
          <div class="collapsible-header valign-wrapper "><i class="material-icons">local_florist</i>LABORATÓRIOS DE MEIO AMBIENTE</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=4&num=1">LAB 1</a></li>
            </ul>
          </div>
        </li>
        <div class="divider"></div>
      </ul>
    </ul>

    <div class="row center">
      <div class="col s12">
        <p class="flow-text">Área de Controle</p>
      </div>
    </div>

    <div class="row center">
      <div class="col s12">
          <!--Mostrar o conteúdo relacionado ao link selecionado-->
           <iframe id="AreaControle" src="<?=$raiz?>/app/view/AreaControle/AreaControle.php">Seu Browser não suporta!</iframe>
      </div>
    </div>

      <!-- Modal Notificações Structure -->
      <div id="modalNotf" class="modal bottom-sheet">
        <div class="modal-content">
          <h4>Notificações</h4>
          <ul class="collection">
          <!--Estrutura da Notificação-->
            <li class="collection-item avatar">
              <i class="material-icons">person</i>
              <span class="title">Nome do professor</span>
              <p>Solicitação de Agendamento: <br>
                 Laboratório I
              </p>
              <div class="secondary-content">
                <a href="#!" class="row green-text"><i class="material-icons left valign-wrapper">thumb_up_alt</i>APROVAR</a>
                <a href="#!" class="row red-text"><i class="material-icons left valign-wrapper">thumb_down_alt</i>RECUSAR</a>
              </div>
            </li>

          </ul>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">FINALIZAR</a>
        </div>
      </div>
    </main>

    

    <footer>
      
    </footer>

      <!--JavaScript at end of body for optimized loading-->
      <script
      src="https://code.jquery.com/jquery-3.3.1.js"
      integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
      crossorigin="anonymous"></script>
      <script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/materialize.js"></script>
      <!--<script type="text/javascript" src="../../../libs/materialize/js/jscustom.js"></script>-->

      <script type="text/javascript">
       $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
        $('.modal').modal();
      });
      </script>
    </body>
  </html>