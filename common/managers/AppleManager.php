<?php


namespace common\managers;


use common\dto\CreateAppleDto;
use common\enums\AppleStatus;
use common\exceptions\SaveModelException;
use common\models\AppleModel;
use common\repositories\AppleRepository;

class AppleManager
{
    /** @var AppleRepository */
    private $repository;

    public function __construct(AppleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateAppleDto $dto
     * @return AppleModel
     * @throws SaveModelException
     */
    public function create(CreateAppleDto $dto): AppleModel
    {
        $model = new AppleModel();
        $model->color = $dto->color;
        $model->status = AppleStatus::getDefault();

        $this->repository->save($model);

        return $model;
    }

    public function fell(AppleModel $model)
    {
        $model->status = AppleStatus::FELL;
        $model->fell_at = (new \DateTime())->format('Y-m-d H:i:s');

        $this->repository->save($model);
    }

    public function rotten(AppleModel $model)
    {
        $model->status = AppleStatus::ROTTEN;

        $this->repository->save($model);
    }

    public function ate(AppleModel $model, int $percents)
    {
        $model->ate += $percents;
        $model->ate = $model->ate > 100 ? 100 : $model->ate;

        if ((int)$model->ate === 100) {
            $this->repository->delete($model);
        } else {
            $this->repository->save($model);
        }
    }
}
