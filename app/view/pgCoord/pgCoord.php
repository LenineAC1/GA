<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/funcoes_global.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/GA/libs/funcoes_php/tratamento_calendario.php';
if (session_id() == '') {
    session_start();
}

    if(!isset($_SESSION['session_login']) || $_SESSION['session_tipo'] != "coordenador"){
        $_SESSION['erro_login'] = 1;
        header("location: $raiz");
    }

//----------------------------------------------Contar o numero de agendamentos pendentes-------------------------------------------------//
$arrayAgendamentos_Pendentes = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta

$countPendentes=0;
foreach ($arrayAgendamentos_Pendentes as $arrayAgendamentos_Pendentes){
if ($arrayAgendamentos_Pendentes['ESTADO_AGENDAMENTO'] == 'em analise') {
    $dataAgendamento = substr($arrayAgendamentos_Pendentes['DATA'], 4, 4) . "-" . substr($arrayAgendamentos_Pendentes['DATA'], 2, 2) . "-" . substr($arrayAgendamentos_Pendentes['DATA'], 0, 2);
    $timestamp_dt = strtotime($dataAgendamento); // converte para timestamp Unix
    $timestamp_dt_expira = strtotime(date("Y-m-d"));
    if ($timestamp_dt < $timestamp_dt_expira) {
    }else {
        $countPendentes++;
    }
}
}
//--------------------------------------------------------------------------------------------------------------------------------//

$arrayAgendamentos = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta
$arrayAgendamentos2 = getAgendamendos($_SESSION['session_login_id']); // Pega os agendamentos da conta

if(!isset($_SESSION['opcCoord'])){
    $_SESSION['opcCoord']="default";
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
      <li class="center">AGENDAMENTOS</li>
        <?php
        if($countPendentes>0){
            echo '<li><a href="" id="AgenPend" class="mudarOpc"><span class="new badge cyan darken-1 pulse" data-badge-caption="nova(s)">'.$countPendentes.'</span>PENDENTES</a></li>';
        }else{
            echo '<li><a href="" id="AgenPend" class="mudarOpc"><span class="new badge cyan darken-1" data-badge-caption="nova(s)">'.$countPendentes.'</span>PENDENTES</a></li>';

        }
        ?>

      <li><a href="" id="AgenHist" class="mudarOpc">HISTÓRICO<i class="material-icons right" style="font-size: 32px; color: rgba(14,14,14,0.92);">history</i></a></li>

        <div class="divider"></div>

        <li class="center">LABORATÓRIOS</li>

        <ul class="collapsible">
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">computer</i>LABORATÓRIOS DE
                    INFORMÁTICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="" id="LabEdit1" class="mudarOpc">LAB 1</a></li>
                        <li><a href="" id="LabEdit2" class="mudarOpc">LAB 2</a></li>
                        <li><a href="" id="LabEdit3" class="mudarOpc">LAB 3</a></li>
                        <li><a href="" id="LabEdit4" class="mudarOpc">LAB 4</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="tiny material-icons">bubble_chart</i>LABORATÓRIOS
                    DE QUÍMICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="" id="LabEdit5" class="mudarOpc">LAB 1</a></li>
                        <li><a href="" id="LabEdit6" class="mudarOpc">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">restaurant</i>LABORATÓRIOS DE
                    NUTRIÇÃO E DIETÉTICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="" id="LabEdit7" class="mudarOpc">LAB 1</a></li>
                        <li><a href="" id="LabEdit8" class="mudarOpc">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper "><i class="material-icons">local_florist</i>LABORATÓRIOS
                    DE MEIO AMBIENTE
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="" id="LabEdit9" class="mudarOpc">LAB 1</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <!--BOTÃO DE SAIR-->
        <div class="divider"></div>
        <li><a href="<?= $raiz ?>/libs/validacoes/login/validacao_deslog.php"><i
                        class="material-icons">close</i>SAIR</a></li>
    </ul>

    <div class="row fundo-row">
      <div class="col s12 fundo-row2" style="padding: 1% 2%">
          <div class="col s12 white z-depth-1 center fundo-row3" style="padding: 0 2%">
          <?php
          if ($_SESSION['opcCoord']=='AgenPend'){
              echo "
              <div id='ModalAgenPen' style='height: 80%; font-size: 85%'>
              <div class='modal-content'>
                  <h4 class='cyan-text text-darken-1 h4Coord' style='margin: 4% auto 4% auto'>Agendamentos pendentes</h4>
                  <table class='centered responsive-table'>
                      <thead>
                      <tr>
                          <th>Data</th>
                          <th>Professor</th>
                          <th>Horario</th>
                          <th>Laboratorio</th>
                          <th>Ano</th>
                          <th>Curso</th>
                          <th>Estado</th>
                          <th> </th>
                      </tr>
                      </thead>

                      <tbody>
                        ";

                      foreach ($arrayAgendamentos as $arrayAgendamentos) {
                          // checa se o agendamento ja passou da data atual
                          if ($arrayAgendamentos['ESTADO_AGENDAMENTO'] == 'em analise') {
                              $Prof = getUserByID($arrayAgendamentos['FK_Conta_ID']);
                              $dataAgendamento = substr($arrayAgendamentos['DATA'], 4, 4) . "-" . substr($arrayAgendamentos['DATA'], 2, 2) . "-" . substr($arrayAgendamentos['DATA'], 0, 2);
                              $timestamp_dt = strtotime($dataAgendamento); // converte para timestamp Unix
                              $timestamp_dt_expira = strtotime(date("Y-m-d"));
                              if ($timestamp_dt < $timestamp_dt_expira) {
                              } else {
                                  echo "<tr>";

                                  echo "<td>" . substr($arrayAgendamentos['DATA'], 0, 2) . "/" . substr($arrayAgendamentos['DATA'], 2, 2) . "/" . substr($arrayAgendamentos['DATA'], 4, 4) . "</td>";
                                  echo "<td>".$Prof['NOME']."</td>";
                                  echo "<td>" . getHorarioByID($arrayAgendamentos['HORARIO']) . "</td>";
                                  echo "<td>" . getNomeLabByID($arrayAgendamentos['FK_O_A_ID']) . "</td>";
                                  echo "<td>" . $arrayAgendamentos['ANO_CURSO'] . "</td>";
                                  echo "<td>" . $arrayAgendamentos['CURSO'] . "</td>";
                                  echo "<td><i class='small material-icons yellow-text text-darken-1'>cached</i></td>";
                                  $AgendamentoID = $arrayAgendamentos['ID'];
                                  echo "<td><a class='waves-effect waves-light btn cyan darken-1' href='$raiz/libs/validacoes/agendamento/permissaoCoord.php?permissao=sim&agendamentoID=$AgendamentoID'>Permitir</a> <a class='waves-effect waves-light btn red darken-1' href='$raiz/libs/validacoes/agendamento/permissaoCoord.php?permissao=nao&agendamentoID=$AgendamentoID'>Negar</a></td>";
                                  echo "</tr>";
                                  $empty="no";
                              }
                          }
                      }

                      echo "

                      </tbody>
                  </table>
              </div>
          </div>
          ";
          }
          else if($_SESSION['opcCoord']=='AgenHist'){
              echo "
              <div id='ModalHistAgen' style='min-height: 84% !important; font-size: 85%''>
              <div class='modal-content'>
                  <h4 class='cyan-text text-darken-1 h4Coord' style='margin: 4% auto 4% auto'>Historico de agendamentos</h4>
                  <table class='centered responsive-table'>
                      <thead>
                      <tr>
                          <th>Data</th>
                          <th>Professor</th>
                          <th>Horario</th>
                          <th>Laboratorio</th>
                          <th>Ano</th>
                          <th>Curso</th>
                          <th>Estado</th>
                          <th>Feedback</th>
                      </tr>
                      </thead>

                      <tbody>

                      ";
                      foreach ($arrayAgendamentos2 as $arrayAgendamentos2) {
                          // checa se o agendamento ja passou da data atual
                          if ($arrayAgendamentos2['ESTADO_AGENDAMENTO'] != "em analise") {
                              $Prof = getUserByID($arrayAgendamentos2['FK_Conta_ID']);
                              echo "<tr>";

                              echo "<td>" . substr($arrayAgendamentos2['DATA'], 0, 2) . "/" . substr($arrayAgendamentos2['DATA'], 2, 2) . "/" . substr($arrayAgendamentos2['DATA'], 4, 4) . "</td>";
                              echo "<td>".$Prof['NOME']."</td>";
                              echo "<td>" . getHorarioByID($arrayAgendamentos2['HORARIO']) . "</td>";
                              echo "<td>" . getNomeLabByID($arrayAgendamentos2['FK_O_A_ID']) . "</td>";
                              echo "<td>" . $arrayAgendamentos2['ANO_CURSO'] . "</td>";
                              echo "<td>" . $arrayAgendamentos2['CURSO'] . "</td>";
                              if ($arrayAgendamentos2['ESTADO_AGENDAMENTO'] == "confirmado") {
                                  echo "<td><i class='small material-icons green-text text-darken-2'>check</i></td>";
                              } else if ($arrayAgendamentos2['ESTADO_AGENDAMENTO'] == "negado") {
                                  echo "<td><i class='small material-icons red-text text-darken-2'>clear</i></td>";
                              } else {
                                  echo "<td><i class='small material-icons yellow-text text-darken-1'>cached</i></td>";
                              }
                              $Feedback = getFeedbackByID($arrayAgendamentos2['ID']);
                              if ($Feedback) {
                                  echo "<td><a class='waves-effect waves-light modal-trigger' id='" . $arrayAgendamentos2['ID'] . "' name='" . $arrayAgendamentos2['ID'] . "' href='#modalVerFeedback" . $arrayAgendamentos2['ID'] . "'><i class='small material-icons cyan-text text-darken-1'>feedback</i></a></td>";
                                  echo " <!-- Modal Ver feedback Structure -->
                                   <div id='modalVerFeedback".$arrayAgendamentos2['ID']."' class='modal modal-fixed-footer modalVerFeedback' style='min-width: 60%;text-align: left'>
                                        <div class='modal-content'>
                                            <h4 class='cyan-text text-darken-1'>Feedback de uso</h4>";
                                  if ($Feedback['CONDICAO']=='nulo'){
                                      echo "<p>Condição de uso: sem informação.</p>";
                                  }else{
                                      switch ($Feedback['CONDICAO']){
                                          case 1: $Feedback['CONDICAO'] = "Ótimo, sem problemas durante o uso.";
                                          break;
                                          case 2: $Feedback['CONDICAO'] = "Mediano, alguns componentes estavam comprometidos.";
                                          break;
                                          case 3: $Feedback['CONDICAO'] ="Ruim, o uso foi afetado negativamente.";
                                          break;
                                      }
                                      echo "<p>Condição de uso: ".$Feedback['CONDICAO']." </p>";
                                  };
                                  echo "
                                              Feedback: <br>".$Feedback['TEXTO_FEEDBACK']."
                                          </div>
                                        <div class='modal-footer'>
                                            <a href='#!'class='fechar-modalFeed waves-effect waves-green btn-flat' id='".$arrayAgendamentos2['ID']."'>Fechar</a>
                                        </div>
                                    </div>";
                              }else{
                                  echo "<td><i class='small material-icons grey-text text-lighten-2'>feedback</i></a></td>";

                              }
                              echo "</tr>";


                          }

                      };

                    echo"
                      </tbody>
                  </table>
              </div>
              
          </div>
          ";
          }
          else if(isset($_SESSION['opcCoordLab']))
          {
            $lab = getLabByID($_SESSION['opcCoord']);
            var_dump($lab);
          }else{
            echo "Escolhe uma fita ae(não sei oq colocar aqui :))";
          }
          ?>

          </div>
      </div>
    </div>

    </main>



    <!-- Modal Notificações Structure -->
    <div id="modalNotf" class="modal bottom-sheet">
        <div class="modal-content container">
            <h4>Notificações</h4>
            <ul class="collection">
                <li id="#notf_content" class="row valign-wrapper"><!--Inicio notificação-->
                    <div class="col s6">
                        <!--Estrutura da Notificação-->
                        <p>
                            Nome: <span>nome do professor</span><!--Nome do professor que solicitou-->
                            <br>
                            Data solicitada: <span>data</span><!--data solicitada-->
                            <br>
                            Solicitação de Agendamento: <span>Laboratório 1</span><!--Nome do lab solicitado-->
                        </p>
                    </div>
                    <div class="col s6 center">
                        <i class="tiny material-icons green-text">done</i>
                        <a href="#!aprovado" class="green-text">APROVAR</a><!--Aceitar solicitação-->
                        <br>
                        <i class="tiny material-icons red-text">delete_outline</i>
                        <a href="#!recusado" class="red-text">RECUSAR</a><!--Recusar solicitação-->
                    </div>
                </li><!--Fim notificação-->
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">FINALIZAR</a>
        </div>
    </div>

    <!-- Modal erro Solicitação Update Structure -->
    <div id="modalErroUpdate" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Erro - Não foi possível atualizar o pedido</h4>
            <p>Não conseguimos atualizar seu pedido tente novamente mais tarde.
                Desculpe o incomodo.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <!-- Modal exito Solicitação Update Structure -->
    <div id="modalExitoUpdate" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Exito - Seu pedido foi atualizado com sucesso</h4>
            <p>O pedido foi atualizado e uma notificação sera enviada ao professor.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    

    <footer>
      
    </footer>

      <!--JavaScript at end of body for optimized loading-->
      <script
      src="https://code.jquery.com/jquery-3.3.1.js"
      integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
      crossorigin="anonymous"></script>
      <script type="text/javascript" src="<?=$raiz?>/libs/materialize/js/materialize.js"></script>
      <script type="text/javascript">
       $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
        $('.modal').modal();
        $('select').formSelect();

            $('.mudarOpc').click(function () {
                    $.ajax({
                        url: "../../../libs/funcoes_php/setsessionOpcCoord.php",
                        type: 'POST', //I want a type as POST
                        data: "name="+$(this).attr('id')
                    });
            });

           var sessao_update = '<?=$_SESSION['retorno_update'] ?? '"nope"';?>';

           $('#modalErroUpdate').modal();
           $('#modalExitoUpdate').modal();

           $('.fechar-modalFeed').click(function (event) {
               var idCerto = '#modalVerFeedback'+event.target.id;
               $(idCerto).modal('close');
           });

           if (sessao_update == "erro") {
               $('#modalErroUpdate').modal('open');
               sessao_update = null;
           } else if (sessao_update == "exito") {
               $('#modalExitoUpdate').modal('open');
               sessao_update = null;
           }


      });
      </script>
    </body>
    <?php if (isset($_SESSION['retorno_update'])) {
        unset($_SESSION['retorno_update']);
    } ?>
  </html>