<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\RateLimit $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="rate-limit-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>
<!---->
<!--                --><?php //echo $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
<!--                --><?php //echo $form->field($model, 'user_id')->textInput() ?>
                <?php echo $form->field($model, 'rate_limit')->textInput() ?>
                <?php echo $form->field($model, 'time_period')->textInput() ?>
<!--                --><?php //echo $form->field($model, 'request_count')->textInput() ?>
                <?php echo $form->field($model, 'type')->dropdownList(\common\models\RateLimit::getTypeOptions()) ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
