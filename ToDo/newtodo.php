<?php
    function saveTodo(): bool {
        $todoName = trim($_POST['todo_name']);
        if ($todoName) {
            $todos = [];
            if (file_exists('./todo.json')) {
                $todos = getTodos();
            }

            $loweredTodoName = strtolower($todoName);
            if (!isset($todos[$loweredTodoName])) {
                $todos[$loweredTodoName] = ['completed' => false, "name" => $todoName];
                putJson($todos);
                return true;
            }
        }
        return false;
    }

    function getTodos() {
        return json_decode(file_get_contents('./todo.json'), true);
    }

    function deleteTask() {
        $todoName = htmlspecialchars_decode($_POST['delete']);
        $todos = getTodos();
        unset($todos[strtolower($todoName)]);
        array_values($todos);
        putJson($todos);
    }

    function putJson($todos) {
        file_put_contents('./todo.json', json_encode($todos, JSON_PRETTY_PRINT));
    }

    function changeState() {
        $todoName = htmlspecialchars_decode($_POST['change']);
        $todos = getTodos();
        $todos[strtolower($todoName)]['completed'] = !$todos[strtolower($todoName)]['completed'];
        putJson($todos);
    }