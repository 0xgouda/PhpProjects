<?php

require_once 'lib/common.php';

session_start();

// Connect to the database , run a query, handle errors
$pdo = getPDO();
if (!isLoggedIn()) {
    redirectAndExit('index.php');
}

$user_id = getUserId($pdo, getUserName());
$articles = getUserArticles($pdo, $user_id);

require 'templates/listArticles.php';