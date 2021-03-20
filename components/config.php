<?php

session_start();

$_SESSION['app_title'] = ucfirst(strtolower("Serapys"));
$_SESSION['logo'] = "img/logo.png";
$_SESSION['logo_only'] = "img/logo_only.png";

require_once('assist/classes/mConnect.php');