<?php
require_once 'lib/common.php';

session_start();
$pdo = getPDO();
$article_id = $_GET['article_id'];
$owner = getarticleOwner($pdo,  $article_id) === getUserName();

if (!isLoggedIn() || !$article_id || !$owner) {
    redirectAndExit('index.php');
}

// Update article
$errors  = $success = null;
if ($_POST && count($_POST) === 2 
    && array_key_exists('new-article-title', $_POST) 
    && array_key_exists('new-article-body', $_POST)) {
        
    if ($owner) {
        editarticle($pdo, $_POST['new-article-title'], $_POST['new-article-body'], $article_id);
        $success['edit'] = 'Your Edits has been Saved.';
    } else {
        $errors['articleId'] = 'Invalid article Id';
    }
}
// Get article Data
$articleData = getarticle($pdo, $_GET['article_id']); 

require_once 'templates/article.php' ?>