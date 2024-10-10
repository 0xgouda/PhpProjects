<?php if ($errors): ?>
    <div class="alert alert-danger py-2" role="alert">
        <ul class="mb-0 small">
            <?php foreach ($errors as $errorName => $errorBody): ?>
                <li><?= $errorName === 'info' ? '' : $errorBody ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>