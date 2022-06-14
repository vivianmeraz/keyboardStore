<?php
session_start();
include 'assets/config/dbconnection.php';
include 'assets/models/functions.php';
//include 'assets/models/functionstest.php';

$pdo = pdo_connect_mysql();
//Routing

#www.keyboardsnmice.com/index.php?page=products&p=2&sortby=price:asc
$page = isset($_GET['page']) && file_exists($_GET['page']) . '.php' ? $_GET['page'] : 'home';
include $page . '.php'

?>
