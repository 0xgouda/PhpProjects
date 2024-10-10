<?php 
require 'lib/common.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && count($_POST) <= 2
    && count($_POST) >= 1
    && isset($_POST['article_id'])) {

    $pdo = getPDO();
    $username = getArticleOwner($pdo, $_POST['article_id']);
    if (isLoggedIn() && $username == getUserName()) {
        if (isset($_POST['comment_id'])) {
            deleteById($pdo, $_POST['comment_id'], 'comment');
            header('location: view-article.php?article_id=' . $_POST['article_id']);
            exit();
        } else {
            deleteById($pdo, $_POST['article_id'], 'article');
        }
    }
}

header('location: account.php');