<?php
    include './partials/header.php';
    include './users/users.php';

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        include 'partials/error.php';
        exit;
    }

    $user_id = $_GET['id'];
    $user = getUserById($user_id);

    if ($user == null) {
        include 'partials/error.php';
        exit;
    }

    $errors = [
        "name" => '',
        "username" => '',
        "email" => '',
        "phone" => '',
        "website" => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $isvalid = validateInput($user, $_POST, $errors);
        
        if ($isvalid) {
            $uploaded = true;
            
            if (isset($_FILES['picture']) && $_FILES['picture']['name'] && $_FILES['picture']['size'] > 0 && $_FILES['picture']['size'] < 5000000 && $_FILES['picture']['error'] === 0) {
                $uploaded = uploadImage($_FILES['picture'], $user);
                $errors['upload'] = 'Error Uploading Image. Please Upload 1-5 Mb .png/.jpeg/.jpg Image';
            }

            if ($uploaded) {
                $user = updateUser($_POST, $user_id);
                header('location: index.php');
            }     
            
        }
    }

    include '_form.php';
    include 'partials/footer.php';