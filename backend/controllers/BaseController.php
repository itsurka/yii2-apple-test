<?php


namespace backend\controllers;


use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

abstract class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => false,
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ],
            parent::behaviors()
        );
    }
}
