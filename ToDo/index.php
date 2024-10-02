<?php
    require './newtodo.php';

    $saved = true;
    
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['todo_name'])) {
            $saved = saveTodo();
        } elseif (isset($_POST['delete'])) {
            deleteTask();
        } elseif (isset($_POST['change'])) {
            changeState();
        }
    }

    $todos = getTodos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>ToDo App</title>
</head>
<body>
    <div class="container mt-3 w-25">
        <div class="card">
            <div class="card-header">
                <b>Create New Todo</b>
            </div>

            <div class="card-body text-center">
                <form action="" method="POST" class="form">
                    <input type="text" name="todo_name" placeholder="New Todo" required 
                        class="<?= $saved ? '' : 'is-invalid'; ?> w-75">
                    <div class="invalid-feedback">
                        Task already exists
                    </div>
                    <input type="hidden" name="delete" value="<?= $todo; ?>">
                    <button class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-3 w-50">
        <table class="table table-bordered">
            <thead class="table-primary">
                <th class="w-25">Task</th>
                <th>Completeion</th>
                <th>Change?</th>
                <th>Remove</th>
            </thead>
            <tbody>
                <?php foreach ($todos as $todo => $valuesArr): ?>
                    <tr>
                        <td><?= htmlspecialchars($valuesArr["name"]); ?></td>
                        <td>
                            <?= $valuesArr["completed"] ? 'Done' : 'Waiting'; ?>
                        </td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="change" value="<?= htmlspecialchars($valuesArr["name"]);?>">
                                <button class="btn btn-success"><?= $valuesArr["completed"] ? 'Waiting' : 'Done' ?></button>
                            </form>
                        </td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="delete" value="<?= htmlspecialchars($valuesArr["name"]);?>">
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>