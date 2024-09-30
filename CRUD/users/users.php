<?php

function getUsersData() {
    $users_data_json = file_get_contents('./users/users.json');
    $users_data = json_decode($users_data_json, true);
    return $users_data;
}

function getUserById($id) {
    $users = getUsersData();
    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }
    return null;
}

function createUser($data) {
    $users = getUsersData();
    $data['id'] = end($users)['id'] + 1;
    $users[] =  $data;

    putJson('./users/users.json', $users);
    return $data;
}

function updateUser($data, $id) {
    $users = getUsersData();
    foreach ($users as $i => $user) {
        if ($user['id'] == $id) {
            $users[$i] = array_merge($user, $data);

            putJson('./users/users.json', $users);
            return $users[$i];
        }
    }
}

function deleteUser($id) {
    $users = getUsersData();
    foreach ($users as $index => $user) {
        if ($user['id'] == $id) {
            unset($users[$index]);
            putJson('./users/users.json', $users);

            if (isset($user['extension'])) {
                unlink('./users/images/' . $user['id'] . '.' . $user['extension']);
            }

            return true;
        }
    }
    return false;
}


function uploadImage($picture, $user) {
    $allowedMimeTypes = ['image/jpeg', 'image/png'];
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    $fileMimeType = mime_content_type($picture['tmp_name']); 
    $fileExtension = pathinfo($picture['name'], PATHINFO_EXTENSION);
    if (!in_array($fileExtension, $allowedExtensions) || !in_array($fileMimeType, $allowedMimeTypes)) {
        return false;
    }
    
    if (!is_dir('./users/images/')) {
        mkdir('./users/images/', 0644);
    }

    $destination = './users/images/' . $user['id'] . '.' . $fileExtension;
    if (!move_uploaded_file($picture['tmp_name'], $destination)) {
        return false;
    }   

    

    $user['extension'] = $fileExtension;
    updateUser($user, $user['id']);
    return true;
}

function putJson($dest, $data) {
    file_put_contents('./users/users.json', json_encode($data, JSON_PRETTY_PRINT));
}

function validateInput(&$user, $data, &$errors) {
    $isvalid = true;

    $allowed_keys = ['name', 'username', 'email', 'phone', 'website'];
    foreach ($data as $key => $value) {
        if (!in_array($key, $allowed_keys)) return false;
    }
    
    $user = array_merge($user, $data);
    
    if (!$user['name'] || strlen($user['name']) > 16 || strlen($user['name']) < 3) {
        $errors['name'] = 'Name is required with length between 3-16';
        $isvalid = false;
    }

    if (!$user['username'] || strlen($user['username']) < 6 || strlen($user['username']) > 16) {
        $errors['username'] = 'Username is required with length between 6-16';
        $isvalid = false;
    }

    if (!$user['email'] || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $isvalid = false;
        $errors['email'] = 'invalid email';
    }

    if (!$user['phone'] || !is_numeric($user['phone'])) {
        $isvalid = false;
        $errors['phone'] = 'Invalid Phone number';
    }

    if (!$user['website'] || !(filter_var($user['website'], FILTER_VALIDATE_DOMAIN) || filter_var($user['website'], FILTER_VALIDATE_URL))) {
        $isvalid = false;
        $errors['website'] = 'Invalid Domain/URL';
    }

    return $isvalid;
}

function escapeOutput(&$user) {
    foreach ($user as $key => $value) {
        $user[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}