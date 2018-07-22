<?php
if (session_id() == '') {
    session_start();
}
$_SESSION['idAgenFeed'] = $_POST['name'];
echo $_SESSION['idAgenFeed'];