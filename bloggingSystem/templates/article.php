<?php 
$path = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require_once 'templates/title.php'; ?>

    <div class="row justify-content-center mb-3">
        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <?php require 'templates/errors.php' ?>
                    
                    <?php if ($path === '/edit-article.php' && $success): ?>
                        <div class="alert alert-success py-2" role="success">
                            <ul class="mb-0 small">
                                <?php foreach ($success as $successName => $successBody): ?>
                                    <li><?= $successBody; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <h5 class="card-title mb-3 text-center">
                        <?php if ($path === '/new-article.php'): ?>                                
                            Write Article
                        <?php else: ?>
                            Edit Article
                        <?php endif; ?>
                    </h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="new-article-title" class="form-label">Title:</label>
                            <input type="text" class="form-control form-control-sm" id="new-article-title" name="new-article-title"
                                value="<?= isset($articleData)? htmlEscape($articleData['title']) : '' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="new-article-body" class="form-label">Content:</label>
                            <textarea rows="10" class="form-control form-control-sm" id="new-article-body" name="new-article-body"><?= isset($articleData) ? htmlEscape($articleData['body']) : '' ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>