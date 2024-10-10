<?php

function installBlog(PDO $pdo): array {
    // Get Project Paths
    $root = getRootPath();
    $database = getDatabasePath();

    $error = '';

    // A security measure, to avoid resetting the database if it already exists
    if (is_readable($database) && filesize($database) > 0) {
        $error = 'Please delete the existing database before installing it again';
    }


    // Create an empty file for the database
    if (!$error) {
        $createdOK = @touch($database);
        if (!$createdOK) {
            $error = sprintf(
                "Could not create the database, please allow the server to create new files in '%s'",
                dirname($database)
            );
        }
    }

    // Grab the SQL commands we want to run on the database
    if (!$error) {
        $sql = file_get_contents($root . '/data/init.sql');

        if ($sql === false) {
            $error = "Cannot find SQL initialization file";
        }
    }

    // Connect to the new database and try to run the SQL commands
    if (!$error) {
        $result = $pdo->exec($sql);
        if ($result === false) {
            $error = "Could not run SQL: " . print_r($pdo->errorInfo(), true);
        }
    }

    // See how many rows we created, if any
    $count = [];

    foreach(['article', 'comment'] as $tableName) {
        if (!$error) {
            $sql = "SELECT COUNT(*) AS c FROM " . $tableName;
            $stmt = $pdo->query($sql);
            if ($stmt) {
                $count[$tableName] = $stmt->fetchColumn();
            }
        }
    }

    return [$count, $error];
}

function createUser(PDO $pdo, string $username, int $length = 10): array {
    // Create a random Password
    $alphabet = range(ord('A'), ord('z'));
    $alphabetLength = count($alphabet);

    $password = '';
    for($i = 0; $i < $length; $i++) {
        $letterCode = $alphabet[rand(0, $alphabetLength - 1)];
        $password .= chr($letterCode);
    }

    $error = '';

    // Update admin Credentials
    $sql = "UPDATE user SET
                password = :password, is_enabled = 1
            WHERE username = :username
            ";
    
    $stmt = $pdo->prepare($sql);
    if ($stmt === false) {
        $error = "Couldn't prepare the user update statement";
    }

    if (!$error) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if (!$hash) {
            $error = "Password Hashing Failed.";
        }
    }

    if (!$error) {
        $result = $stmt->execute(
            [
                'username' => $username,
                'password' => $hash
            ]
        );

        if ($result === false) {
            $error = "Couldn't Create User";
        }
    }

    if ($error) $password = '';

    return [$password, $error];
}