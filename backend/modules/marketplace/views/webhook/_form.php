<?php

use common\models\SupplierBuyer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\Webhook $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="webhook-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'supplier_buyer_id')->dropDownList(
                    ArrayHelper::map(SupplierBuyer::find()->all(), 'id', 'name'),
                    ['prompt' => 'Tanlang...']
                ); ?>
                <?php echo $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'token')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'status')->textInput() ?>
                
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
