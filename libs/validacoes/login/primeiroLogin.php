<?php
$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
require_once '../../funcoes_php/funcoes_global.php';
session_start(); //Inicia sessão

$conexao_pdo = conexao_pdo('lobmanager_db', 'root', ''); // realiza a conexão com o banco de dados

   $id_user = $_SESSION['session_login_id'];

   $user = getUserByID($id_user);

   $NewSenhaMD5 = md5(md5($_POST['password1']));

   if($user['PERMISSAO'] == 'prof_perm_first'){
       $query = $conexao_pdo->prepare("UPDATE `user` SET `PERMISSAO` = 'prof_perm' WHERE `user`.`ID` = :idUser;"); //prepara a query de seleção onde as informações são correspondentes
       $query->bindParam(':idUser', $id_user);
       if($query->execute()){
       $query2 = $conexao_pdo->prepare("UPDATE `user` SET `SENHA` = :newSenha WHERE `user`.`ID` = :idUser2;");
       $query2->bindParam(':newSenha', $NewSenhaMD5);
       $query2->bindParam(':idUser2', $id_user);
       if ($query2->execute()) {
           $_SESSION['session_login'] = $user['EMAIL']; // salva login realizado em uma sessão para uso posterior
           $_SESSION['session_tipo'] = $user['TIPO']; // salva tipo da conta realizado em uma sessão para uso posterior

           header("location: $raiz");
       }else{
           header("location: $raiz?1");
           $_SESSION['erro_login'] = 1;
       }
       }else{
           header("location: $raiz?2");
           $_SESSION['erro_login'] = 1;
       }
   }else if($user['PERMISSAO'] == 'coord_perm_first'){
       $query = $conexao_pdo->prepare("UPDATE `user` SET `PERMISSAO` = 'coord_perm' WHERE `user`.`ID` = :idUser;"); //prepara a query de seleção onde as informações são correspondentes
       $query->bindParam(':idUser', $id_user);
       if($query->execute()) {
           $query2 = $conexao_pdo->prepare("UPDATE `user` SET `SENHA` = :newSenha WHERE `user`.`ID` = :idUser2;");
           $query2->bindParam(':newSenha', $NewSenhaMD5);
           $query2->bindParam(':idUser2', $id_user);
           if ($query2->execute()) {
               $_SESSION['session_login'] = $user['EMAIL']; // salva login realizado em uma sessão para uso posterior
               $_SESSION['session_tipo'] = $user['TIPO']; // salva tipo da conta realizado em uma sessão para uso posterior

               header("location: $raiz");
           }else{
               header("location: $raiz");
               $_SESSION['erro_login'] = 1;
           }
       }else{
           header("location: $raiz");
           $_SESSION['erro_login'] = 1;
       }
   }
