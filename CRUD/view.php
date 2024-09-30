<?php
    require './users/users.php';
    
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

    include './partials/header.php';

    escapeOutput($user);
?>
<div class="container">
    <div class="card my-3">
        <div class="card-header">
            <h3>View User: <b><?= $user['name'];?></b></h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <?php if (isset($user['extension'])): ?>
                        <tr>
                            <th>Image: </th>
                            <td>
                                <img style="width: 60px" src="<?= "./users/images/" . $user['id'] . "." . $user['extension']; ?>" alt="User Image">
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Name:</th>
                        <td><?= $user['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Username:</th>
                        <td><?= $user['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?= $user['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Phone:</th>
                        <td><?= $user['phone']; ?></td>
                    </tr>
                    <tr>
                        <th>Website:</th>
                        <td>
                            <a target="_blank" href="http://<?= $user['website']; ?>"><?= $user['website']; ?></a>
                        </td>
                    </tr>
                    <tr>
                        <th>Operations:</th>
                        <td>
                            <a href="update.php?id=<?= $user['id']; ?>" class="btn btn-secondary">Update</a>
                            <form action="delete.php" method="POST" class="my-1 d-inline">
                                <input type="hidden" name="id" value="<?= $user['id'];?>">
                                <button class="btn btn-danger">Delete</button>
                            </form>                        
                        </td>
                    </tr>
                </tbody>
            </div>
        </table>
    </div>
</div>


<?php include 'partials/footer.php';?>