<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="../../../libs/materialize/css/materialize.css"  media="screen,projection"/>
      <!--Import custom.css-->
      <link type="text/css" rel="stylesheet" href="../../../libs/materialize/css/custom.css"  media="screen,projection"/>

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
    <main>
      
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li class="center red darken-3">
          <a href="#"><img src="../_img/logoGA.png" style="height: 15px;"></a>
      </li>
      <!-- Modal Notificações Trigger -->
      <li><a class="modal-trigger" href="#modal1"><span class="new badge red darken-3">1</span>NOTIFICAÇÕES</a></li>
      <li><a href="#!">LAB I</a></li>
      <li><a href="#!">LAB II</a></li>
      <li><a href="#!">LAB III</a></li>
      <li><a href="#!">LAB IV</a></li>
      <li><a href="#!">HISTÓRICO DE AGENDAMENTOS</a></li>
    </ul>

    <div class="row">
      <div class="col s12">
        <p class="flow-text">Área de Controle</p>
          <nav class="z-depth-0 red darken-3">
            <div class="nav-wrapper">
              <div class="col s12">
                <a href="#!" class="breadcrumb">First</a>
                <a href="#!" class="breadcrumb">Second</a>
                <a href="#!" class="breadcrumb">Third</a>
              </div>
            </div>
          </nav>
        </div>
    </div>

      <!-- Modal Notificações Structure -->
      <div id="modal1" class="modal">
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
      <script type="text/javascript" src="../../../libs/materialize/js/materialize.min.js"></script>
      <script type="text/javascript" src="../../../libs/materialize/js/jscustom.js"></script>
      <script type="text/javascript" src="../../../libs/jquery.js"></script>
    </body>
  </html>