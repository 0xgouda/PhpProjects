<?php 
$path = getFileName();
?>

<div class="container">
    <div class="row align-items-center my-4">
        <div class="col-md-8 text-center text-md-start">
            <h1 class="display-4 text-primary">BlogVerse</h1>
            <p class="lead text-muted">A Universe of Words.</p>
        </div>
        <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
            <?php if (isLoggedIn()): ?>
                <?php if ($path !== "index.php"): ?>
                    <a href="index.php" class="btn btn-outline-primary">Home</a>
                <?php endif; ?>
                <?php if ($path === "account.php"): ?>
                    <a href="new-article.php" class="btn btn-outline-success">New Article</a>
                <?php else: ?>
                    <a href="account.php" class="btn btn-outline-success">Account</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
                <h4 class="text-primary my-3">Hello, <?= htmlEscape(getAuthUser()) ?></h4>
            <?php else: ?>
                <a href="register.php" class="btn btn-outline-primary">Register</a>
                <a href="login.php" class="btn btn-outline-primary">Login</a>
            <?php endif; ?>
        </div>
    </div>
</div>