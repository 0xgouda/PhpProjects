<?php

require_once 'lib/common.php';

session_start();

// Connect to the database , run a query, handle errors
$pdo = getPDO();
$articles = getAllArticles($pdo);

require 'templates/listArticles.php';