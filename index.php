<?php
session_start(); //Inicia sessão
if(isset($_SESSION['erro_login']) && $_SESSION['erro_login'] === 1){ // checa se teve erro anteriormente
    // TRATE A MODAL DE ERRO AQUI

    //---
    $_SESSION['erro_login'] = 0; // reseta sessão de erro para evitar loop
  }
if (isset($_SESSION['session_login'])) { //Testa se ja existe uma sessão de login
    $tipo_conta = $_SESSION['session_tipo']; //Pega o tipo de conta
    if ($tipo_conta == "coordenador") { //Testa se é do tipo coordenador
        header("location: app/view/pgCoord/pgCoord.php"); //Redireciona para pagina de coordenador
    } else if ($tipo_conta == "professor") { //Testa se é do tipo professor
        header("location: app/view/pgProfessor/pgProfessor.php"); //Redireciona para pagina de professor
      }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.css" media="screen,projection"/>
      <!--Import custom.css-->
      <link type="text/css" rel="stylesheet" href="libs/materialize/css/custom.css" media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

      <?php require 'app/view/head.php'; ?>

      <main>
        <div class="container">
          <div class="col s12">
            <div class="card large horizontal">
              <div class="card-stacked">
                <div class="card-content">
                  <h4>Login:</h4>
                  <form method="post" action="libs/validacoes/login/validacao_login.php" class="col s12"
                  ">
                  <div class="row">
                    <div class="input-field col s12">
                      <input name="login_email" id="email" type="email" class="validate">
                      <label for="email" class="red-text text-darken-3">Email</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <input name="login_senha" id="senha" type="password" class="validate">
                      <label for="senha" class="red-text text-darken-3">Senha</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12">
                      <button class="btn-large red darken-3 waves-effect waves-light" type="submit"
                      name="action">Submit
                      <i class="material-icons right">send</i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card-image hide-on-med-and-down">
            <img src="app/view/_img/bg1.jpg">
          </div>
        </div>
      </div>
    </div>

    
  <!-- Modal Erro -->
  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a>

  <!-- Modal Erro Structure -->
  <div id="modalErro" class="modal">
    <div class="modal-content">
      <h4>Error 1 - Não foi possível realizar o Login</h4>
      <p>Não conseguimos realizar seu login tente novamente mais tarde.
      Desculpe o incomodo.
      </p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
    </div>
  </div>
          

  </main>
  <footer>
  </footer>
  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="libs/materialize/js/materialize.js"></script>
  <script type="text/javascript" src="libs/materialize/js/jscustom.js"></script>
  <script type="text/javascript" src="libs/jquery.js"></script>
  <script type="text/javascript">
   $(document).ready(function(){
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('.modal').modal();
  });
</script>
</body>
</html>