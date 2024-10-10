<?php
require_once 'lib/common.php';

session_start();

// Handle the form posting
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && count($_POST) === 3
    && isset($_POST['username']) 
    && isset($_POST['password'])
    && isset($_POST['confirm-password'])) {
    
    // init the db connection
    $pdo = getPDO();

    $username = $_POST['username'];
    $success = register($pdo, $username, $_POST['password']);

    if ($success) {
        redirectAndExit('login.php');
    }
}

require 'templates/login_regsiter.php';