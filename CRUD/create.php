<?php
    require './users/users.php';
    include './partials/header.php';

    $errors = [
        "name" => '',
        "username" => '',
        "email" => '',
        "phone" => '',
        "website" => '',
        "upload" => ''
    ];

    $user = [
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
            $user = createUser($_POST);

            if (isset($_FILES['picture']) && $_FILES['picture']['name'] && $_FILES['picture']['size'] > 0 && $_FILES['picture']['size'] < 5000000 && $_FILES['picture']['error'] === 0) {
                $uploaded = uploadImage($_FILES['picture'], $user);
            }

            if ($uploaded) {
                header('location: index.php');
            } else {
                deleteUser($user['id']);
                $errors['upload'] = 'Error Uploading Image. Please Upload .png/.jpeg/.jpg Image';
            }
            
        }
    }


    include '_form.php';
    include 'partials/footer.php';