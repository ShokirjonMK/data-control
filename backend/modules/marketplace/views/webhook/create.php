<?php

/**
 * @var yii\web\View $this
 * @var common\models\Webhook $model
 */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Webhook',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Webhooks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webhook-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
