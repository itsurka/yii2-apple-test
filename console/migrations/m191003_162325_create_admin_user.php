<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m191003_162325_create_admin_user
 */
class m191003_162325_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $model = new User();
        $model->username = 'admin';
        $model->password = 'admin';
        $model->generateAuthKey();
        $model->email = 'admin@apple-test.local';
        $model->status = User::STATUS_ACTIVE;
        if (!$model->save()) {
            throw new \yii\base\Exception('Can not save user');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::deleteAll(['username' => 'admin']);
    }
}
