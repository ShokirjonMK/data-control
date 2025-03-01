<?php

use yii\helpers\Html;
use yii\grid\GridView;

/**
 * @var yii\web\View $this
 * @var backend\models\search\RateLimitSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'Rate Limits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rate-limit-index">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Create Rate Limit', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="card-body p-0">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php echo GridView::widget([
                'layout' => "{items}\n{pager}",
                'options' => [
                    'class' => ['gridview', 'table-responsive'],
                ],
                'tableOptions' => [
                    'class' => ['table', 'text-nowrap', 'table-striped', 'table-bordered', 'mb-0'],
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'rate_limit',
                    'time_period',
                    [
                        'attribute' => 'type',
                        'value' => function (\common\models\RateLimit $model) {
                            return $model->getTypeLabel();
                        },
                        'filter' => \common\models\RateLimit::getTypeOptions(), // filter uchun dropdown tanlovlari
                    ],

                    ['class' => \common\widgets\ActionColumn::class],
                ],
            ]); ?>


        </div>
        <div class="card-footer">
            <?php echo getDataProviderSummary($dataProvider) ?>
        </div>
    </div>

</div>
