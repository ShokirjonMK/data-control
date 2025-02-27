<?php

/**
 * @var yii\web\View $this
 * @var common\models\SupplierBuyer $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Supplier Buyer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Supplier Buyers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-buyer-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
