<?php
require_once 'lib/common.php';

session_start();

$article_id = $_GET['article_id'];
if (!isLoggedIn() || !(isset($_GET['article_id']) && is_numeric($_GET['article_id'])) ) {
    redirectAndExit('index.php');
}

$pdo = getPDO();
$owner = getarticleOwner($pdo,  $article_id) === getUserName();
if (!$owner) redirectAndExit('index.php');

// Update article
$errors  = $success = null;
if ($_POST && count($_POST) === 2 
    && checkVar('new-article-title') 
    && checkVar('new-article-body')) {
        
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