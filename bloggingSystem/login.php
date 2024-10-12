<?php
require_once 'lib/common.php';

session_start();

// Handle the form posting
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        count($_POST) === 2
        && checkVar('username')
        && checkVar('password')
    ) {

        // init the db connection
        $pdo = getPDO();

        $username = $_POST['username'];
        $success = tryLogin($pdo, $username, $_POST['password']);

        if ($success) {
            // Create new id for the new login
            login($username);
            redirectAndExit('index.php');
        }
    } else $success = false;
}
require 'templates/login_regsiter.php';
