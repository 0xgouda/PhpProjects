<?php
    include 'partials/header.php';
    include 'users/users.php';

    if (isset($_POST['id']) && is_numeric($_POST['id']) && deleteUser($_POST['id'])) {
        header('location: index.php');
    }
    else include 'partials/error.php';

    include 'partials/footer.php';