<?php

function getRootPath(): string {
    return realpath(__DIR__ . '/..');
}

function getDatabasePath(): string {
    return getRootPath() . '/data/data.sqlite';
}

function getDsn(): string {
    return 'sqlite:' . getDatabasePath();
}

function getPDO(): object {
    return new PDO(getDsn());
}

function htmlEscape(string $html): string {
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

function convertSqlDate(string $sqlDate) {
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);
    return $date->format('d M Y');
}

function countCommentsForArticle(PDO $pdo, int $articleId): int {
    $sql = "SELECT
                COUNT(*) AS c
            FROM
                comment
            WHERE
                article_id = :article_id
            ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['article_id' => $articleId]);

    return (int) $stmt->fetchColumn();
}

function getCommentsForArticle(PDO $pdo, int $articleId) {
    $sql = "SELECT
                id, name, text, created_at
            FROM
                comment
            WHERE
                article_id = :article_id
            ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['article_id' => $articleId]);

    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $comments;
}

function redirectAndExit($destination) {
    header("location: " . $destination);
    exit();
}

function convertNewLinesToParagraphs($text) {
    $escaped = htmlEscape($text);
    return "<p>" . str_replace("\n", "</p><p>", $escaped) . "</p>";
}

function tryLogin(PDO $pdo, $username, $password) {
    $sql = "SELECT password
                FROM
                    user
                WHERE
                    username = :username
            ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    $hash = $stmt->fetchColumn();
    $success = password_verify($password, $hash);
    
    return $success;
}

function login($username) {
    session_regenerate_id();
    $_SESSION['logged_in_username'] = $username;
}

function logout(): void {
    // empty the session variable
    $_SESSION = [];

    // set the session for the client to be expired 
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params['path'], $params['domain'],
    $params['secure'], $params['httponly']);

    // remove the session from the server
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['logged_in_username']);
}

function getAuthUser() {
    return isLoggedIn() ? getUserName() : null;
}

function createArticle(PDO $pdo, string $title, string $body, int $id) {
    $sql = "INSERT INTO 
                article (
                    title, body, user_id, created_at
                )
                VALUES (
                    :title,
                    :body,
                    :id,
                    date('now')
                )";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'title' => $title, 'body' => $body]);
}

function editArticle(PDO $pdo, string $title, string $body, int $id) {
    $sql = "UPDATE article SET
                title = :title,
                body = :body,
                updated_at = date('now')
            WHERE id = :id
            ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'body' => $body, 'id' => $id]);
}

function getUserId(PDO $pdo, string $username) {
    $sql = "SELECT id FROM
                user
            WHERE
                username = :username
            ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);

    return $stmt->fetchColumn();
}

function getArticleOwner(PDO $pdo, int $article_id) {
    $sql = "SELECT user_id FROM
                article
            WHERE
                id = :article_id
            ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['article_id' => $article_id]);

    $user_id = $stmt->fetchColumn();

    // get Username
    $sql = "SELECT 
                username 
            FROM 
                user 
            WHERE 
                id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    return $stmt->fetchColumn();
}

function getUserArticles(PDO $pdo, int $user_id) {
    $sql = "SELECT id, title, created_at, body
            FROM article
            WHERE user_id = :user_id
            ORDER BY created_at DESC";    
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllArticles(PDO $pdo) {
    $sql = "SELECT id, title, created_at, body, user_id
            FROM article
            ORDER BY created_at DESC";    
    
    $stmt = $pdo->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getArticle(PDO $pdo, int $article_id) {
    $sql = "SELECT title, body
            FROM article
            WHERE id = :article_id";    
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['article_id' => $article_id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function register($pdo, $username, $password) {
    $user_id = getUserId($pdo, $username);
    
    if ($user_id) {
        return false;
    }

    $sql = "INSERT INTO 
                user (
                    username, password, created_at, is_enabled
                ) 
            VALUES (
                    :username, :hash, date('now'), 1
                )";
    
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'hash' => $hash]);
    
    return true;
}

function deleteById(PDO $pdo, int $id, string $table): void {
    $sql = "DELETE 
            FROM 
                $table
            WHERE   
                id = :id
            ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

function getUserName() {
    return $_SESSION['logged_in_username'];
}