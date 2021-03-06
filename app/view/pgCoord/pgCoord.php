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

if (isset($_GET['id_lab'])) {
    $_SESSION['id_lab_coord'] = $_GET['id_lab'];
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
      
    <ul id="slide-out" class="sidenav sidenav-fixed" style="overflow-y: auto">
      <li class="center red darken-3">
          <a href="#"><img src="<?=$raiz?>/app/view/_img/logoGA.png" style="height: 50px;"></a>
      </li>
        <?php
        $user = getUserByID($_SESSION['session_login_id']);
        ?>
        <!-- Modal Notificações Trigger // Alterar o número de novas notificações-->
        <li class="center"> <?= $user['NOME']?></li>
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

        <li class="center">EDITAR OBJETOS DE AGENDAMENTO</li>

        <ul class="collapsible">
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">computer</i>LABORATÓRIOS DE
                    INFORMÁTICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=1" id="EditLab" class="mudarOpc">LAB 1</a></li>
                        <li><a href="?id_lab=2" id="EditLab" class="mudarOpc">LAB 2</a></li>
                        <li><a href="?id_lab=3" id="EditLab" class="mudarOpc">LAB 3</a></li>
                        <li><a href="?id_lab=4" id="EditLab" class="mudarOpc">LAB 4</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">bubble_chart</i>LABORATÓRIOS
                    DE QUÍMICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=5" id="EditLab" class="mudarOpc">LAB 1</a></li>
                        <li><a href="?id_lab=6" id="EditLab" class="mudarOpc">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper"><i class="material-icons">restaurant</i>LABORATÓRIOS DE
                    NUTRIÇÃO E DIETÉTICA
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=7" id="EditLab" class="mudarOpc">LAB 1</a></li>
                        <li><a href="?id_lab=8" id="EditLab" class="mudarOpc">LAB 2</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper "><i class="material-icons">local_florist</i>LABORATÓRIOS
                    DE MEIO AMBIENTE
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=9" id="EditLab" class="mudarOpc">LAB 1</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper "><i class="material-icons">camera</i>PROJETORES
                </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=10" id="EditLab" class="mudarOpc">PROJETOR 1</a></li>
                        <li><a href="?id_lab=11" id="EditLab" class="mudarOpc">PROJETOR 2</a></li>
                        <li><a href="?id_lab=12" id="EditLab" class="mudarOpc">PROJETOR 3</a></li>
                        <li><a href="?id_lab=13" id="EditLab" class="mudarOpc">PROJETOR 4</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header valign-wrapper "><i class="material-icons">meeting_room</i>SALA NIVONEI
                    </div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="?id_lab=14" id="EditLab" class="mudarOpc">SALA NIVONEI</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <!--BOTÃO DE SAIR-->
        <div class="divider"></div>
        <li><a href="<?= $raiz ?>/libs/validacoes/login/validacao_deslog.php"><i
                        class="material-icons">close</i>SAIR</a></li>
        <li><a class="modal-trigger" href="#modalReport"><i class="material-icons">report_problem</i></a></li>
    </ul>

    <div class="row fundo-row">
      <div class="col s12 fundo-row2" style="padding: 1% 2%">
          <div class="col s12 white z-depth-1 fundo-row3" style="padding: 0 2%">
          <?php
          if(!isset($_SESSION['opcCoord']) || $_SESSION['opcCoord']=='default'){
              $_SESSION['opcCoord']='AgenPend';
          }
          if ($_SESSION['opcCoord']=='AgenPend'){
              echo "
              <div id='ModalAgenPen' style='height: 80%; font-size: 85%'>
              <div class='modal-content center'>
                  <h4 class='cyan-text text-darken-1 h4Coord' style='margin: 4% auto 4% auto'>Agendamentos pendentes</h4>
                  <table class='centered responsive-table bordered'>
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
                  
                ";
              if (!isset($empty)){
                  echo "<div style='padding:4%;font-size:1.5vw'>Sem agendamentos pendentes, por favor volte mais tarde</div>";
              }
              echo "
          
              </div>
          </div>
          ";
          }
          else if($_SESSION['opcCoord']=='AgenHist'){
              echo "
              <div id='ModalHistAgen' style='min-height: 84% !important; font-size: 85%''>
              <div class='modal-content center'>
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
                                   <div id='modalVerFeedback".$arrayAgendamentos2['ID']. "' class='modal modal-fixed-footer modalVerFeedback' style='min-width: 10%;text-align: left'>
                                        <div class='modal-content'>
                                         
                                            <h4 class='cyan-text text-darken-1'>Feedback de uso</h4>";
                                  if ($Feedback['CONDICAO']=='nulo'){
                                      echo "<p>Condição de uso: sem informação.</p>";
                                  }else{
                                      echo "<p>Condição de uso: ".getCondicaoFraseFeed($Feedback['CONDICAO'])." </p>";
                                  };
                                  echo "
                                              Feedback: <br>".$Feedback['TEXTO_FEEDBACK']."
                                          </div>
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
          else if ($_SESSION['opcCoord']=="EditLab") {
              $labInfos = getLABbyID($_SESSION['id_lab_coord']);
              echo "
              <div id='ModalEditLab' style='min-height: 84% !important; font-size: 85%;'>
              <div class='modal-content '>
                  <h4 class='cyan-text text-darken-1 h4Coord' style='margin: 4% auto 4% auto;text-align: center'>Editar laboratório</h4>
                  <span style='font-size: 1.7vw;text-align: center'><p contenteditable='true' id='LabNome'>
             ".$labInfos["NOME"]."
              </p></span>
              <div style='margin: 3% 5% 4% 5%;'>
              <span style='text-align: justify;'><p contenteditable='true' id='LabText'>
                 ".$labInfos["DESCRICAO"]."
                 </p></span>
                 <button id='salvarLab' class='waves-effect waves-light btn cyan darken-1 center' style='margin-top: 2%;width: 100%'>Salvar</button>
                 </div>
                 
              </div>
          </div>
          ";
          }
          ?>
          <!-- Modal agendamentos pendentes Structure -->


          <!-- Modal agendamentos historico Structure -->

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

    <!-- Modal erro Solicitação Structure -->
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
    <!-- Modal exito Solicitação Structure -->
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

    <div id="modalExitoUpdateLab" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Exito - Os dados foram atualizados com sucesso</h4>
            <p>A alteração foi realizada com sucesso.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <div id="modalErroUpdateLab" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Erro - Os dados não foram atualizados com sucesso</h4>
            <p>A alteração não foi realizada com sucesso, por favor tente mais tarde.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <!-- Modal exito report Structure -->
    <div id="modalExitoReport" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Exito - Seu report foi enviado com sucesso</h4>
            <p>Seu report foi enviado para a administração, obrigado por sua ajuda.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <!-- Modal erro report Structure -->
    <div id="modalErroReport" class="modal retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Erro - Seu report não foi enviado</h4>
            <p>Por favor tente mais tarde, desculpe o incomodo.
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
        </div>
    </div>

    <!-- Modal report Structure -->
    <div id="modalReport" class="modal modal-fixed-footer retorno">
        <div class="modal-content">
            <h4 class="cyan-text text-darken-1">Reclamações e BUGS</h4>
            <p>Que tipo de informação você deseja enviar:
                <form id="reportform" method="post" action="<?= $raiz ?>/libs/funcoes_php/criacaoReport.php">
                    <div class="input-field col s12">
                        <select name="select_report" form="reportform" required>
                            <option value="" selected>---</option>
                            <option value="1">Suegestões</option>
                            <option value="2" >BUGS</option>
                        </select>
                    </div>
            <p>Descreva sua experiencia:</p>
            <div class="input-field col s12">
                <textarea id="textReport" name="textReport" class="materialize-textarea" minlength="5" required></textarea>
            </div>

            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Fechar</a>
            <button type="submit" class="waves-effect waves-green btn-flat" id="submit_report">Enviar</button>

        </div>
        </form>
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
           var sessao_retorno_report = "<?=$_SESSION['retorno_report'] ?? 'nope';?>";

           $('#modalErroUpdate').modal();
           $('#modalExitoUpdate').modal();
           $('#modalExitoUpdateLab').modal();
           $('#modalErroUpdateLab').modal();

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

           if (sessao_retorno_report == "erro") {
               $('#modalErroReport').modal('open');
               sessao_retorno_report = null;
           }
           else if (sessao_retorno_report== "exito") {
               $('#modalExitoReport').modal('open');
               sessao_retorno_report = null;
           }


           $('#salvarLab').click(function () {
               var nome = document.getElementById("LabNome").innerText;
               var text = document.getElementById("LabText").innerText;
               var id = '<?=$_SESSION['id_lab_coord'] ?? '""';?>';

               $.ajax({
                   url: "../../../libs/funcoes_php/UpdateLabInfo.php",
                   type: 'POST', //I want a type as POST
                   data: {nome_lab: nome, texto_lab: text, id_lab: id},
                   success: function (data) {
                       if (data == "sucesso"){
                           $('#modalExitoUpdateLab').modal('open')
                       }else{
                           $('#modalErroUpdateLab').modal('open')
                       }
                   }

               });

           });

      });
      </script>
    </body>
    <?php if (isset($_SESSION['retorno_update'])) {
        unset($_SESSION['retorno_update']);
        if(isset($_SESSION['retorno_report'])){
            unset($_SESSION['retorno_report']);
        }
    } ?>
  </html>