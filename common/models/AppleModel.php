<?php

namespace common\models;

use common\enums\AppleColor;
use common\enums\AppleStatus;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property string $created_at
 * @property string $fell_at
 * @property string $status
 * @property int $ate
 */
class AppleModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'status'], 'required'],
            [['color', 'status'], 'string'],
            ['status', 'in', 'range' => AppleStatus::getKeys()],
            ['color', 'in', 'range' => AppleColor::getKeys()],
            [['created_at', 'fell_at'], 'safe'],
            [['ate'], 'integer', 'min' => 0, 'max' => 100],
        ];
    }
}
