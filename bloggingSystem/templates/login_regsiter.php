<?php 
    if (getFileName()=== 'login.php') {
        $path = 'Login';
        $error = 'Invalid Username or Password.';
    } elseif (getFileName() === 'register.php') {
        $path = 'Register';
        $error = "Please Fill all Fields or Choose another Username";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $path ?> | BlogVerse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body">

                        <h1 class="display-4 text-primary text-center my-3">BlogVerse</h1>

                        <h2 class="card-title text-center mb-4"><?= $path ?></h2>

                        <?php if (isset($success) && !$success): ?>
                            <div class="alert alert-danger py-2" role="alert">
                                <ul class="mb-0 small">
                                    <li><?= $error ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <?php if ($path === 'Register'): ?>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Confirm Password:</label>
                                    <input type="password" class="form-control" id="password" name="confirm-password" required>
                                </div>
                            <?php endif; ?>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>