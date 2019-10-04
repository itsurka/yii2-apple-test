<?php

namespace backend\controllers;

use common\entities\Apple;
use common\enums\AppleColor;
use common\enums\AppleStatus;
use common\exceptions\UnacceptablyAppleActionException;
use common\managers\AppleManager;
use Yii;
use common\models\AppleModel;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for AppleModel model.
 */
class AppleController extends BaseController
{
    /** @var $appleManager AppleManager */
    private $appleManager;

    public function __construct($id, $module, AppleManager $appleManager, $config = [])
    {
        $this->appleManager = $appleManager;

        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AppleModel models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AppleModel::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFell($id)
    {
        $model = $this->findModel($id);

        $apple = Apple::load($model);

        try {
            $apple->fell();
        } catch (UnacceptablyAppleActionException $exception) {
            Yii::$app->session->addFlash('warning', 'This apple can not fell');
        }

        return $this->redirect('index');
    }

    public function actionAte($id)
    {
        $model = $this->findModel($id);

        $apple = Apple::load($model);

        try {
            $apple->ate(25);
        } catch (UnacceptablyAppleActionException $exception) {
            Yii::$app->session->addFlash('warning', 'This apple is not edible');
        }

        return $this->redirect('index');
    }

    /**
     * @return \yii\web\Response
     * @throws \common\exceptions\SaveModelException
     */
    public function actionCreateBatch()
    {
        $count = rand(2, 5);

        for ($i = 0; $i < $count; $i++) {
            $colors = AppleColor::getKeys();
            $color = $colors[array_rand($colors)];
            new Apple($color);
        }

        Yii::$app->session->addFlash('success', sprintf('Added %s apples', $count));

        return $this->redirect('index');
    }

    public function actionScrollTime()
    {
        $q = AppleModel::find()->andWhere(['status' => AppleStatus::FELL])->orderBy(['id' => SORT_ASC]);

        /** @var AppleModel $model */
        foreach ($q->each() as $model) {
            $dateCreated = new \DateTime($model->created_at);
            $dateCreated->sub(new \DateInterval('PT5H'));
            $model->created_at = $dateCreated->format('Y-m-d H:i:s');

            $dateFell = new \DateTime($model->fell_at);
            $dateFell->sub(new \DateInterval('PT5H'));
            $model->fell_at = $dateFell->format('Y-m-d H:i:s');

            $model->save(false);
        }

        return $this->redirect('index');
    }
    
    /**
     * Finds the AppleModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return AppleModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppleModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
