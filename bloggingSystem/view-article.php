<?php

require_once 'lib/common.php';
require_once 'lib/view-article.php';

session_start();

// Get the article ID
if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) $articleId = $_GET["article_id"];
else redirectAndExit('index.php');

// Connect to the database, run a query, handle errors
$pdo = getPDO();
$row = getArticleRow($pdo, $articleId);

if (!$row) redirectAndExit('index.php');

// Add Comment
$errors = null;
if (checkVar('comment-text')) {
    $comment = $_POST['comment-text'];

    $errors = addCommentToArticle($pdo, $articleId, $comment);
}

// Get Comments number/body
$count = countCommentsForArticle($pdo, $articleId);
$comments = getCommentsForArticle($pdo, $articleId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-4">
        <?php require 'templates/title.php'; ?>

        <article class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0"><?= htmlEscape($row['title']); ?></h2>
                <a href="edit-article.php?article_id=<?= $articleId ?>" class="btn btn-success">Edit</a>
            </div>

            <p class="text-muted"><small><?= convertSqlDate($row['created_at']); ?></small></p>
            <div class="mb-4">
                <?= convertNewLinesToParagraphs($row['body']) ?>
        </article>

        <section class="mb-4">
            <h3 class="mb-3 text-center"><?= $count ?> Comments</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($comments as $comment): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="card-title d-flex justify-content-between align-items-center">
                                    <strong><?= htmlEscape($comment['name']) ?></strong>
                                    <div>
                                        <small class="text-muted"><?= convertSqlDate($comment['created_at']) ?></small>
                                        <?php if (getAuthUser() === getArticleOwner($pdo, $articleId)): ?>
                                            <form action="delete.php" method="POST" class="d-inline ms-2">
                                                <input type="hidden" name="article_id" value="<?= $articleId ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" value="<?= $comment['id'] ?>" name="comment_id">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="overflow-auto" style="max-height: 100px;">
                                    <p class="mb-1"><?= convertNewLinesToParagraphs($comment['text']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php if (isLoggedIn()) {
            require 'templates/comment-form.php';
        } ?>
    </div>

</body>

</html>