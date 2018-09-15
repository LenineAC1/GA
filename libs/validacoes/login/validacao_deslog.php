<?php
/**
 * Created by PhpStorm.
 * User: Lenine
 * Date: 02/07/2018
 * Time: 17:25
 */

$raiz = 'http://'.$_SERVER['HTTP_HOST']."/GA";
session_start();
if(isset($_SESSION['session_login'])){
    session_unset();
    header("location: $raiz");
}else{
    header("location: $raiz");
}