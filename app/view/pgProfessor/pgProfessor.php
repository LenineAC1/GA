<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";


session_start();
if(!isset($_SESSION['session_login']) || $_SESSION['session_tipo'] != "professor"){
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
      <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0"/>
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
              <li><a href="#cont?tipo=1&num=1">LAB 1</a></li>
              <li><a href="#cont?tipo=1&num=2">LAB 2</a></li>
              <li><a href="#cont?tipo=1&num=3">LAB 3</a></li>
              <li><a href="#cont?tipo=1&num=4">LAB 4</a></li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header valign-wrapper"><i class="tiny material-icons">bubble_chart</i>LABORATÓRIOS DE QUÍMICA</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=2&num=1">LAB 1</a></li>
              <li><a href="#cont?tipo=2&num=2">LAB 2</a></li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header valign-wrapper"><i class="material-icons">restaurant</i>LABORATÓRIOS DE NUTRIÇÃO E DIETÉTICA</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=3&num=1">LAB 1</a></li>
              <li><a href="#cont?tipo=3&num=2">LAB 2</a></li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header valign-wrapper "><i class="material-icons">local_florist</i>LABORATÓRIOS DE MEIO AMBIENTE</div>
          <div class="collapsible-body">
            <ul>
              <li><a href="#cont?tipo=4&num=1">LAB 1</a></li>
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
          <p class="flow-text">07/2018</p>
      </div>
    </div>

    <div class="row center">
      <table class="centered striped">
        <thead>
          <tr>
            <th>D</th>
            <th>S</th>
            <th>T</th>
            <th>Q</th>
            <th>Q</th>
            <th>S</th>
            <th>S</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
          </tr>
          <tr>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td>13</td>
            <td>14</td>
          </tr>
          <tr>
            <td>15</td>
            <td>16</td>
            <td>17</td>
            <td>18</td>
            <td>19</td>
            <td>20</td>
            <td>21</td>
          </tr>
          <tr>
            <td>22</td>
            <td>23</td>
            <td>24</td>
            <td>25</td>
            <td>26</td>
            <td>27</td>
            <td>28</td>
          </tr>
          <tr>
            <td>29</td>
            <td>30</td>
            <td>31</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>
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