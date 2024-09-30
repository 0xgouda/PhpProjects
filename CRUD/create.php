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
            
            if (isset($_FILES['picture']) && $_FILES['picture']['name'] && $_FILES['picture']['size'] > 0 && $_FILES['picture']['size'] < 5000000 && $_FILES['picture']['error'] === 0) {
                $uploaded = uploadImage($_FILES['picture'], $user);
                $errors['upload'] = 'Error Uploading Image. Please Upload .png/.jpeg/.jpg Image';
            }

            if ($uploaded) {
                $user = createUser($_POST);
                header('location: index.php');
            }     
            
        }
    }


    include '_form.php';
    include 'partials/footer.php';