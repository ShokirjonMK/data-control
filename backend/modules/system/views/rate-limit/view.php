<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\RateLimit $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rate Limits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-limit-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
//                    'ip',
//                    'user_id',
                    'rate_limit',
                    'time_period',
//                    'request_count',
                    [
                        'attribute' => 'type',
                        'value' => function (\common\models\RateLimit $model) {
                            return $model->getTypeLabel();
                        },
                    ],
                    'created_at',
                    'updated_at',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
