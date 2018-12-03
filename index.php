<?php
session_start(); //Inicia sessão
if (isset($_SESSION['session_login'])) { //Testa se ja existe uma sessão de login
    $tipo_conta = $_SESSION['session_tipo']; //Pega o tipo de conta
    if ($tipo_conta == "coordenador") { //Testa se é do tipo coordenador
        header("location: app/view/pgCoord/pgCoord.php"); //Redireciona para pagina de coordenador

    } else if ($tipo_conta == "professor") { //Testa se é do tipo professor
        header("location: app/view/pgProfessor/pgProfessor.php"); //Redireciona para pagina de professor
      } else if ($tipo_conta == "admin"){
        header("location: app/view/pgAdmin/pgAdmin.php"); //Redireciona para pagina de professor

    }
    }
    ?>

    <!DOCTYPE html>
    <html>
    <head>

      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,700" rel="stylesheet">

      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.css" media="screen,projection"/>
      <!--Import custom.css-->
      <link type="text/css" rel="stylesheet" href="libs/materialize/css/custom.css" media="screen,projection"/>

    <script>
        function check(input) {
            if (input.value != document.getElementById('password1').value) {
                input.setCustomValidity('As senhas devem ser iguais !!');

            } else {
                // input is valid -- reset the error message
                input.setCustomValidity('');
            }
        }
    </script>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
    <style>
        header, main, footer {
            padding-left: 0;
        }
    </style>

<body>
      <?php require 'app/view/head.php'; ?>

      <main>
        <div class="container">
          <div class="col s12">
            <div class="card large horizontal">
              <div class="card-stacked">
                <div class="card-content">
                  <h4>ENTRAR:</h4>
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
                      name="action">Entrar
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
  <a class="waves-effect waves-light btn modal-trigger" id="abrir_modal" href="#modalErro" style="display: none;">Modal</a>
  <a class="waves-effect waves-light btn modal-trigger" id="abrir_modal_senha" href="#modalErroSenha" style="display: none;">Modal</a>

  <!-- Modal Erro Structure -->
  <div id="modalErro" class="modal retorno">
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

          <div id="modalErroSenha" class="modal retorno">

              <div class="modal-content">
                  <h4 class="cyan-text text-darken-1">Primeiro acesso, altere sua senha</h4>
                <form method="post" action="libs/validacoes/login/primeiroLogin.php">
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password1" id="password1" type="password" class="validate" pattern=".{5,}" required title="3 characters minimum" >
                            <label for="password1">Nova senha (Tamanho minimo: 5 caracteres)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password2" id="password2" type="password" class="validate" pattern=".{5,}" required title="3 characters minimum" oninput="check(this)">
                            <label for="password2">Repita sua senha</label>
                        </div>
                    </div>

              </div>
              <div class="modal-footer" style="margin-bottom: 3%;padding-right: 5%;">
                  <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
                  <button class='btn waves-effect waves-light cyan darken-2' id="senhaSub" type='submit'>Continuar
                      <i class='material-icons right'>send</i>
                  </button>
              </div>
              </form>
          </div>
  </main>
  <footer>
  </footer>
  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="libs/materialize/js/materialize.js"></script>
  <script type="text/javascript" src="libs/materialize/js/jscustom.js"></script>
  <script type="text/javascript" src="libs/jquery.js"></script>

      <?php
      if(isset($_SESSION['erro_login']) && $_SESSION['erro_login'] === 1){ // checa se teve erro anteriormente
          // TRATE A MODAL DE ERRO AQUI
            echo '<script type="text/javascript"> document.getElementById(\'abrir_modal\').click(); </script>';
          //---
          $_SESSION['erro_login'] = 0; // reseta sessão de erro para evitar loop
      }else if (isset($_SESSION['erro_login']) && $_SESSION['erro_login'] === 2){
          // TRATE A MODAL DE ERRO AQUI
          echo '<script type="text/javascript"> document.getElementById(\'abrir_modal_senha\').click(); </script>';
          //---
          $_SESSION['erro_login'] = 0; // reseta sessão de erro para evitar loop
      }
      ?>

  <script type="text/javascript">
   $(document).ready(function(){
       $('.sidenav').sidenav();
       $('.collapsible').collapsible();
       $('.modal').modal();
  });
</script>
</body>
</html>
