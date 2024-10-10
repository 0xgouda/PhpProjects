<?php
require_once 'lib/common.php';

session_start();
if (!isLoggedIn()) {
    redirectAndExit('account.php');
}

$errors = $success = null;
if ($_POST && count($_POST) === 2 
    && array_key_exists('new-article-title', $_POST) 
    && array_key_exists('new-article-body', $_POST)) {
    
    if (!$_POST['new-article-title']) {
        $errors['title'] = 'a Title is required';
    }
    if (!$_POST['new-article-body']) {
        $errors['text'] = 'A Content is required';
    }

    if (!$errors) {
        $pdo = getPDO();
        $id = getUserId($pdo, getUserName());
        createArticle($pdo, $_POST['new-article-title'], $_POST['new-article-body'], $id);
        redirectAndExit('index.php');
    }
}

require_once 'templates/article.php' ?>