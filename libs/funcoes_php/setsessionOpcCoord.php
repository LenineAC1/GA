<?php
if (session_id() == '') {
    session_start();
}
$_SESSION['opcCoord'] = $_POST['name'];
if (strpos($_SESSION['opcCoord'], 'LabEdit') !== false){
    $_SESSION['opcCoordLab']=$_SESSION['opcCoord'];
    $_SESSION['opcCoord'] = str_replace("LabEdit",'',$_SESSION['opcCoord']);
}
