<?php

function getArticleRow(PDO $pdo, int $articleId) {
    $stmt = $pdo->prepare(
        'SELECT
                title, created_at, body
            FROM
                article
            WHERE
                id = :id
            '
    );
    
    if ($stmt === false) {
        throw new Exception("There was a problem preparing this query");
    }
    
    $result = $stmt->execute(
        ['id' => $articleId]
    );
    
    if ($result === false) {
        throw new Exception("There was a problem running this query");
    }
    
    // Get a row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $row;
}

function addCommentToArticle(PDO $pdo, $articleId, string $comment) {
    $errors = [];

    // Do some validation
    if (!$comment) {
        $errors['text'] = 'comment is required';
    }
    
    // If we are error free, try writing the comment
    if (!$errors) {
        $sql = "INSERT INTO
                    comment (
                        article_id, created_at, name, text
                    )
                    VALUES (
                        :article_id, date('now'), :name, :text
                    )
                ";
        
        $stmt = $pdo->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Cannot Prepare Statement to Insert The Comment");
        } 
        
        $name = getUserName();
        $result = $stmt->execute(['article_id' => $articleId, 'name' => $name, 'text' => $comment]);

        if ($result === false) {
            $errorInfo = $stmt->errorInfo();
            if ($errorInfo) {
                $errors[] = $errorInfo[2];
            }
        }
    }
    return $errors;
}