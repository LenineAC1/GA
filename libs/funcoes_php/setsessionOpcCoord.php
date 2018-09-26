<?php
if (session_id() == '') {
    session_start();
}
$_SESSION['opcCoord'] = $_POST['name'];
echo $_SESSION['opcCoord'];