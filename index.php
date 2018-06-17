<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="libs/materialize/css/materialize.css"  media="screen,projection"/>
      <!--Import custom.css-->
      <link type="text/css" rel="stylesheet" href="libs/materialize/css/custom.css"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>

    <?php require 'app/view/head.php';?>

    <main>
      <div class="container">
          <div class="col s12">
            <div class="card large horizontal">
              <div class="card-stacked">
                <div class="card-content">
                  <h4>Login:</h4>
                  <form method="post" action="libs/validacoes/login/validacao_login.php" class="col s12"">
                    <div class="row">
                      <div class="input-field col s12">
                        <input name="login_email" id="email" type="email" class="validate">
                        <label for="email" class="red-text text-darken-3" >Email</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12">
                        <input name="login_senha" id="senha" type="password" class="validate">
                        <label for="senha" class="red-text text-darken-3" >Senha</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col s12">
                        <button class="btn-large red darken-3 waves-effect waves-light" type="submit" name="action">Submit
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
    </main>

    <footer>

    </footer>

      <!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="libs/materialize/js/materialize.js"></script>
      <script type="text/javascript" src="libs/materialize/js/jscustom.js"></script>
      <script type="text/javascript" src="libs/jquery.js"></script>
    </body>
  </html>