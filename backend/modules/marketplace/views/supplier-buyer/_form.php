<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\SupplierBuyer $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="supplier-buyer-form">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]); ?>
    <div class="card">
        <div class="card-body">
            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->field($model, 'group')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'name_eng')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'main_delivery_address')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'stock_percentage')->textInput(['type' => 'number', 'step' => '0.01']) ?>
            <?php echo $form->field($model, 'stock_expiry')->textInput(['type' => 'number']) ?>
            <?php echo $form->field($model, 'legal_entity')->checkbox() ?>
            <?php echo $form->field($model, 'is_supplier')->checkbox() ?>
            <?php echo $form->field($model, 'is_buyer')->checkbox() ?>
            <?php echo $form->field($model, 'depositor')->checkbox() ?>
            <?php echo $form->field($model, 'contract_date')->textInput(['type' => 'date']) ?>
            <?php echo $form->field($model, 'bank_details')->textarea(['rows' => 4]) ?>
            <?php echo $form->field($model, 'contact_info')->textarea(['rows' => 4]) ?>
            <?php echo $form->field($model, 'additional_details')->textarea(['rows' => 4]) ?>
            <?php echo $form->field($model, 'contract_number')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'kpp')->textInput(['maxlength' => true]) ?>
            <?php echo $form->field($model, 'okpo')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="card-footer">
            <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
