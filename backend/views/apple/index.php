<?php

use common\entities\Apple;
use common\enums\AppleColor;
use common\enums\AppleStatus;
use common\models\AppleModel;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Apples!', ['create-batch'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('back 5 hours!', ['scroll-time'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'color',
                'value' => function (AppleModel $model) {
                    return AppleColor::getLabel($model->color);
                }
            ],
            'created_at',
            'fell_at',
            [
                'attribute' => 'status',
                'value' => function (AppleModel $model) {
                    return AppleStatus::getLabel($model->status);
                }
            ],
            [
                'attribute' => 'ate',
                'value' => function (AppleModel $model) {
                    return Yii::$app->formatter->asPercent($model->ate / 100);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{fell}\n{ate}",
                'buttons' => [
                    'fell' => function ($url, $model, $key) {
                        $apple = Apple::load($model);
                        if (!$apple->canFell()) {
                            return '';
                        }
                        return Html::a('Fell', $url, ['data-method' => 'POST']);
                    },
                    'ate' => function ($url, $model, $key) {
                        $apple = Apple::load($model);
                        if (!$apple->canAte()) {
                            return '';
                        }
                        return Html::a('Eat', $url, ['data-method' => 'POST']);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
