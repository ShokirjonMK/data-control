<?php

/**
 * @var yii\web\View $this
 * @var common\models\SupplierBuyer $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
        'modelClass' => 'Supplier Buyer',
    ]) . ' update.php' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Supplier Buyers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="supplier-buyer-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
