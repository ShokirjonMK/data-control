<?php

/**
 * @var yii\web\View $this
 * @var common\models\Webhook $model
 */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Webhook',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Webhooks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="webhook-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
