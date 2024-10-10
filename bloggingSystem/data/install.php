<?php

require_once '../lib/common.php';
require_once '../lib/install.php';

// Check if we have installed
$attempted = false;

// Only run the installer when we'are responding to the form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install']) && $_POST['install'] === 'Install') {
    // Here's the install
    $pdo = getPDO();
    list($rowsCount, $error) = installBlog($pdo);
    $attempted = true;

    $password = '';
    if (!$error) {
        $username = 'admin';
        list($password, $error) = createUser($pdo, $username);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog installer</title>
</head>

<body>
    <?php if ($attempted): ?>
        <?php if ($error): ?>
            <div class="error box">
                <?= $error; ?>
            </div>
        <?php else: ?>
            <div class="success box">
                The database and demo data was created OK.
                <?php foreach (['article', 'comment'] as $tableName): ?>
                    <?php if (isset($rowsCount[$tableName])): ?>
                        <?= $rowsCount[$tableName]; ?> new
                        <?= $tableName; ?>s 
                        were created.
                    <?php endif; ?>
                <?php endforeach; ?>

                The "<?= htmlEscape($username) ?>" Password is 
                <span>"<?= $password ?>"</span>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Click the install button to reset the database.</p>

        <form method="POST">
            <input type="submit" name="install" value="Install">
        </form>
    <?php endif; ?>
</body>

</html>