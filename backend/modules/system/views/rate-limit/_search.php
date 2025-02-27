<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\RateLimit $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="rate-limit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'ip') ?>
    <?php echo $form->field($model, 'user_id') ?>
    <?php echo $form->field($model, 'rate_limit') ?>
    <?php echo $form->field($model, 'time_period') ?>
    <?php // echo $form->field($model, 'request_count') ?>
    <?php // echo $form->field($model, 'type') ?>
    <?php // echo $form->field($model, 'created_at') ?>
    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
