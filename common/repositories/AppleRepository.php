<?php


namespace common\repositories;


use common\exceptions\DeleteModelException;
use common\exceptions\SaveModelException;
use common\models\AppleModel;

class AppleRepository
{
    public function save(AppleModel $model)
    {
        if (!$model->save()) {
            throw new SaveModelException('Save apple model failed', $model->errors);
        }
    }

    public function delete(AppleModel $model)
    {
        if (!$model->delete()) {
            throw new DeleteModelException('Delete apple failed');
        }
    }
}
