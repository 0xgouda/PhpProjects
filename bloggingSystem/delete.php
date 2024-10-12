<?php 
require 'lib/common.php';
session_start();

$count = count($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && $count <= 2
    && $count >= 1
    && checkVar($_POST['article_id'])) {

    $pdo = getPDO();
    $username = getArticleOwner($pdo, $_POST['article_id']);
    if (isLoggedIn() && $username == getUserName()) {
        
        if (checkVar($_POST['comment_id']) && $count === 2) {
            deleteById($pdo, $_POST['comment_id'], 'comment');
            header('location: view-article.php?article_id=' . $_POST['article_id']);
            exit();
        } 
        
        if ($count === 1 && checkVar('article_id')) {
            deleteById($pdo, $_POST['article_id'], 'article');
        }
    }
}

header('location: account.php');