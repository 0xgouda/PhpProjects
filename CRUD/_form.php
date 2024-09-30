<?php 
    escapeOutput($user);
    escapeOutput($errors); 
?>

<div class="container">
    <div class="card my-3">
        <div class="card-header">
            <h3>
                <?php if (isset($user['id'])): ?>
                    Update User: <b><?= $user['name'];?></b>
                <?php else: ?>
                    Create new User
                <?php endif; ?>
            </h3>
        </div>

        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group my-2">
                    <label>Name</label>
                    <input name="name" required value="<?= $user['name']; ?>" 
                        class="form-control <?php echo $errors['name']? 'is-invalid':''; ?>">
                    <div class="invalid-feedback">
                        <?= $errors['name'];?>
                    </div>
                </div>
                <div class="form-group my-2">
                    <label>Username</label>
                    <input name="username" required value="<?= $user['username']; ?>" 
                        class="form-control <?php echo $errors['username']? 'is-invalid':''; ?>">
                    <div class="invalid-feedback">
                        <?= $errors['username'];?>
                    </div>
                </div>
                <div class="form-group my-2">
                    <label>Email</label>
                    <input name="email" type="email" required value="<?= $user['email']; ?>" class="form-control
                        <?php echo $errors['email']? 'is-invalid':''; ?>">
                    <div class="invalid-feedback">
                        <?= $errors['email'];?>
                    </div>
                </div>
                <div class="form-group my-2">
                    <label>Phone</label>
                    <input name="phone" required value="<?= $user['phone']; ?>" class="form-control
                        <?php echo $errors['phone']? 'is-invalid':''; ?>">
                    <div class="invalid-feedback">
                        <?= $errors['phone'];?>
                    </div>
                </div>
                <div class="form-group my-2">
                    <label>Website</label>
                    <input name="website" required value="<?= $user['website']; ?>" class="form-control
                        <?php echo $errors['website']? 'is-invalid':''; ?>">
                    <div class="invalid-feedback">
                        <?= $errors['website'];?>
                    </div>
                </div>
                <div class="form-group my-2">
                    <label>Image</label>
                    <input name="picture" type="file" 
                        class="form-control-file <?php echo $errors['upload']? 'is-invalid':''; ?>">
                    <div class="invalid-feedback">
                        <?= $errors['upload'];?>
                    </div>
                </div>

                <button class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>