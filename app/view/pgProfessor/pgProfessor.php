<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";


session_start();
if(!$_SESSION['session_login'] || $_SESSION['session_tipo'] != "professor"){
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
    <main>
      
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li class="center red darken-3">
          <a href="#"><img src="../_img/logoGA.png" style="height: 15px;"></a>
      </li>
      <li><a href="#!">Agendar</a></li>
      <li><a href="#!">Verificar Agendamentos</a></li>
    </ul>

    <div class="container">
      <h2>Período</h2>
            <ul class="collapsible z-depth-0">
              <li>
                <div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>ETIM/Ensino Médio Regular</div>
                <div class="collapsible-body"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Praesentium aliquam minima earum ipsa a velit impedit illum, perspiciatis, enim nihil. Quo voluptatem officiis dolorum eaque! Iure ipsa nisi quibusdam, cupiditate.</span></div>
              </li>
              <li>
                <div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>Modular</div>
                <div class="collapsible-body"><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel quia fugiat veniam dicta deserunt, enim suscipit distinctio voluptates, iste quasi, sint provident ullam vero? Saepe mollitia quod illo culpa id.</span></div>
              </li>
            </ul>
        
    </div>
    </main>

    <footer>
      
    </footer>

      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/materialize.min.js"></script>
      <script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/jscustom.js"></script>
      <script type="text/javascript" src="<?=$raiz?>/libs/jquery.js"></script>
    </body>
  </html>