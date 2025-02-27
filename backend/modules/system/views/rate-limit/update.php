<?php

/**
 * @var yii\web\View $this
 * @var common\models\RateLimit $model
 */

$this->title = 'Update Rate Limit: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rate Limits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rate-limit-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
