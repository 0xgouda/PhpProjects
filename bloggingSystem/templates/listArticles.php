<?php 
    $path = getFileName();
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
    <div class="container py-4">
        <?php require 'templates/title.php'; ?>

        <?php if ($path === 'account.php'): ?>
            <h1 class="text-center text-success">Your Articles.</h1>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (isset($articles)): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h2 class="card-title h5">
                                    <?= htmlEscape($article['title']); ?>
                                </h2>
                                <p class="card-text text-muted small">
                                    <?php if ($path === 'index.php'): ?>
                                        Author: <?= htmlEscape(getArticleOwner($pdo, $article['id'])); ?>
                                        <br>
                                    <?php endif; ?>
                                    <?= convertSqlDate($article['created_at']); ?>
                                    (<?= countCommentsForArticle($pdo, $article['id']); ?> comments)
                                </p>
                                <p class="card-text">
                                    <?= htmlEscape(substr($article['body'], 0, 50)) . '...'; ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <a href="view-article.php?article_id=<?= $article['id']; ?>" class="btn btn-primary">Read more</a>
                                <?php if (getArticleOwner($pdo, $article['id']) === getAuthUser()): ?>
                                    <a href="edit-article.php?article_id=<?= $article['id']; ?>" class="btn btn-success">Edit</a>
                                    <form action="delete.php" method="POST" class="d-inline">
                                        <button type="submit" name="article_id" value="<?= $article['id']; ?>" class="btn btn-danger">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>