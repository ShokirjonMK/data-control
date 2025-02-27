<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container">
    <h2>Migration Management</h2>

    <div class="mb-3">
        <form method="post" action="<?= Url::to(['migration/new-migration']) ?>">
            <input type="text" name="name" class="form-control" placeholder="Enter migration name" required>
            <button type="submit" class="btn btn-primary mt-2">Create Migration</button>
        </form>
    </div>

    <div class="mb-3">
        <form method="post" action="<?= Url::to(['migration/run-up']) ?>">
            <button type="submit" class="btn btn-success">Run Up Migration</button>
        </form>
    </div>

    <div class="mb-3">
        <form method="post" action="<?= Url::to(['migration/run-down']) ?>">
            <button type="submit" class="btn btn-danger">Run Down Migration</button>
        </form>
    </div>

    <?php if (isset($output)): ?>
        <h3>Command Output</h3>
        <pre style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;">
            <?= Html::encode($output) ?>
        </pre>
    <?php endif; ?>
</div>
