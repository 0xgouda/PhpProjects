<?php
require_once 'lib/common.php';

session_start();

// Handle the form posting
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        count($_POST) === 3
        && checkVar('username')
        && checkVar('password')
        && checkVar('confirm-password')
        && $_POST['password'] === $_POST['confirm-password']
    ) {

        // init the db connection
        $pdo = getPDO();

        $username = $_POST['username'];
        $success = register($pdo, $username, $_POST['password']);

        if ($success) {
            redirectAndExit('login.php');
        }
    } else $success = false;
}

require 'templates/login_regsiter.php';
