<?php

/**
 * @var yii\web\View $this
 * @var common\models\RateLimit $model
 */

$this->title = 'Create Rate Limit';
$this->params['breadcrumbs'][] = ['label' => 'Rate Limits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-limit-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
