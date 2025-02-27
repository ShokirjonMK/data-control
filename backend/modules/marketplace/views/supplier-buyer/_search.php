<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\SupplierBuyer $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="supplier-buyer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'group') ?>
    <?php echo $form->field($model, 'code') ?>
    <?php echo $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'full_name') ?>
    <?php // echo $form->field($model, 'name_eng') ?>
    <?php // echo $form->field($model, 'status') ?>
    <?php // echo $form->field($model, 'created_at') ?>
    <?php // echo $form->field($model, 'updated_at') ?>
    <?php // echo $form->field($model, 'deleted_at') ?>
    <?php // echo $form->field($model, 'created_by') ?>
    <?php // echo $form->field($model, 'updated_by') ?>
    <?php // echo $form->field($model, 'deleted_by') ?>
    <?php // echo $form->field($model, 'customer_status') ?>
    <?php // echo $form->field($model, 'parent_id') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
