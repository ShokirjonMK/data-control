<?php
use yii\helpers\Url;
?>

<script>
    function addColumnRow() {
        const row = `<div class='row mb-2 column-row'>
                        <div class='col-md-2'>
                            <input type='text' name='columns[][name]' class='form-control' placeholder='Column Name' required>
                        </div>
                        <div class='col-md-1'>
                            <select name='columns[][type]' class='form-control' required>
                                <option value='string'>String</option>
                                <option value='integer'>Integer</option>
                                <option value='boolean'>Boolean</option>
                                <option value='text'>Text</option>
                                <option value='float'>Float</option>
                                <option value='date'>Date</option>
                            </select>
                        </div>
                        <div class='col-md-2'>
                            <input type='number' name='columns[][length]' class='form-control' placeholder='Length (Optional)'>
                        </div>
                        <div class='col-md-2'>
                            <select name='columns[][nullable]' class='form-control' required>
                                <option value='false'>NOT NULL</option>
                                <option value='true'>NULL</option>
                            </select>
                        </div>
                        <div class='col-md-2'>
                            <input type='text' name='columns[][default]' class='form-control' placeholder='Default Value'>
                        </div>
                        <div class='col-md-1'>
                            <input type='text' name='columns[][foreign_table]' class='form-control' placeholder='Foreign Table'>
                        </div>
                        <div class='col-md-1'>
                            <input type='text' name='columns[][foreign_column]' class='form-control' placeholder='Foreign Column'>
                        </div>
                        <div class='col-md-1'>
                            <button type='button' class='btn btn-danger remove-column'>Remove</button>
                        </div>
                    </div>`;
        document.getElementById('columnsContainer').insertAdjacentHTML('beforeend', row);
    }

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-column')) {
            e.target.closest('.column-row').remove();
        }
    });
</script>

<div class="px-5">
    <h2>Generate Migration</h2>

    <form method="post" action="<?= Url::to(['migration-generator/generate']) ?>">
        <div class="mb-3">
            <input type="text" name="tableName" class="form-control" placeholder="Table Name" required>
        </div>

        <div id="columnsContainer" class="mb-3">
            <h3>Columns</h3>
            <div class="row mb-2 column-row">
                <div class="col-md-2">
                    <input type="text" name='columns[][name]' class='form-control' placeholder='Column Name' required>
                </div>

                <div class="col-md-1">
                    <select name='columns[][type]' class='form-control' required>
                        <option value='string'>String</option>
                        <option value='integer'>Integer</option>
                        <option value='boolean'>Boolean</option>
                        <option value='text'>Text</option>
                        <option value='float'>Float</option>
                        <option value='date'>Date</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name='columns[][length]' class='form-control' placeholder='Length (Optional)'>
                </div>
                <div class="col-md-2">
                    <select name='columns[][nullable]' class='form-control' required>
                        <option value='false'>NOT NULL</option>
                        <option value='true'>NULL</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name='columns[][default]' class='form-control' placeholder='Default Value'>
                </div>
                <div class="col-md-1">
                    <input type="text" name='columns[][foreign_table]' class='form-control' placeholder='Foreign Table'>
                </div>
                <div class="col-md-1">
                    <input type="text" name='columns[][foreign_column]' class='form-control' placeholder='Foreign Column'>
                </div>
                <div class="col-md-1">
                    <button type='button' class='btn btn-danger remove-column'>Remove</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mt-2" onclick="addColumnRow()">Add Column</button>
        <button type="submit" class="btn btn-primary mt-2">Generate Migration</button>
    </form>
    <br>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success mt-3">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger mt-3">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
</div>
