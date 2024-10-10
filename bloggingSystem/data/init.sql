/*
    Database Creation Script
*/

/* enable foreign keys */
PRAGMA foreign_keys = ON; 

DROP TABLE IF EXISTS user;

CREATE TABLE user (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at VARCHAR(255) NOT NULL,
    is_enabled BOOLEAN NOT NULL DEFAULT true
); 

INSERT INTO 
    user (
        username, password, created_at, is_enabled
    ) 
    VALUES (
        "admin", "password", date('now'), 0
    );

DROP TABLE IF EXISTS article;

CREATE TABLE article (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    title VARCHAR(255) NOT NULL,
    body VARCHAR(255) NOT NULL,
    user_id INTEGER NOT NULL,
    created_at VARCHAR(255) NOT NULL,
    updated_at VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

INSERT INTO
    article (
        title, body, user_id, created_at
    )
    VALUES (
        "Here's our first article",
        "this is the body of the first article.
        
        
        it is split into paragraphs",
        1,
        date('now', '-2 months', '-3 days', '-45 minutes', '+17 seconds')
    );

INSERT INTO 
    article (
        title, body, user_id, created_at
    )
    VALUES (
        "Now for a second article",
        "This is the body of the second article.
        This is another paragraph",
        1,
        date('now', '-40 days', '+815 minutes', '+37 seconds')
    );

INSERT INTO
    article (
        title, body, user_id, created_at
    )
    VALUES (
        "Here's a third article",
        "this is the body of the third article.
        This is split into paragraphs.",
        1,
        date('now', '-13 days' , '-32 minutes', '+8 seconds')
    );

DROP TABLE IF EXISTS comment;

CREATE TABLE comment (
    id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    article_id INTEGER NOT NULL,
    created_at VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    text VARCHAR(255) NOT NULL,
    FOREIGN KEY (article_id) REFERENCES article(id)
);

INSERT INTO comment (
        article_id, created_at, name, text
    )

    VALUES (
        1,
        date('now', '-10 days' , '-45 minutes', '+10 seconds'),
        'Jimmy',
        "This is Jimmy's contribution"
    );

INSERT INTO comment (
        article_id, created_at, name, text
    )
    VALUES (
        2,
        date('now', '-5 days' , '-25 minutes', '+12 seconds'),
        'Johnny',
        "This is a Comment From Johnny"
    ); 