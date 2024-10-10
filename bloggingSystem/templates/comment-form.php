<div class="row justify-content-center mb-3">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="card">
            <div class="card-body">
                <?php require 'templates/errors.php' ?>

                <h5 class="card-title mb-3 text-center">Add A Comment</h5>

                <form method="POST">
                    <div class="mb-3">
                        <label for="comment-text" class="form-label">Comment:</label>
                        <textarea class="form-control form-control-sm" rows="4" id="comment-text" name="comment-text"><?= isset($commentData['text']) && $errors ? htmlEscape($commentData['text']) : '' ?></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-sm">Submit Comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>