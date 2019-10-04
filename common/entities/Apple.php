<?php


namespace common\entities;


use common\dto\CreateAppleDto;
use common\enums\AppleStatus;
use common\exceptions\UnacceptablyAppleActionException;
use common\managers\AppleManager;
use common\models\AppleModel;
use Yii;

/**
 * Class Apple
 *
 * @package common\entities
 */
class Apple
{
    /** @var AppleModel */
    private $model;

    /**
     * Apple constructor.
     *
     * @param string|null $color
     * @param AppleModel|null $model
     */
    public function __construct(?string $color = null, ?AppleModel $model = null)
    {
        if ($color) {
            $this->model = $this->createModel($color);
        } elseif (!$model) {
            throw new \InvalidArgumentException('Either color or model is required');
        }
        $this->model = $model;
    }

    public static function load(AppleModel $model): Apple
    {
        return new static(null, $model);
    }

    public function fell()
    {
        if (!$this->canFell()) {
            throw new UnacceptablyAppleActionException();
        }

        $this->getManager()->fell($this->model);
    }

    public function canFell()
    {
        return $this->model->status === AppleStatus::ON_TREE;
    }

    public function ate(int $percents)
    {
        if (!$this->canAte()) {
            throw new UnacceptablyAppleActionException();
        }

        $this->getManager()->ate($this->model, $percents);
    }

    public function canAte()
    {
        if ($this->model->status !== AppleStatus::FELL) {
            return false;
        }

        if ($this->isRotten()) {
            $this->getManager()->rotten($this->model);

            return false;
        }

        return true;
    }

    public function isRotten()
    {
        if ($this->model->status !== AppleStatus::FELL) {
            return false;
        }

        $fellDate = (new \DateTime($this->model->fell_at))->getTimestamp() + (5 * 3600);

        return $fellDate < time();
    }

    private function createModel(string $color)
    {
        $this->model = $this->getManager()->create(CreateAppleDto::loadFromArray([
            'color' => $color
        ]));
    }

    private function getManager(): AppleManager
    {
        return Yii::$container->get(AppleManager::class);
    }
}
