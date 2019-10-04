<?php

namespace common\dto;


trait LoadFromArray
{
    /**
     * Наполнение объекта
     *
     * @param array $data Данные
     * @param bool|true $withEmptyStr Заполнять ли параметры пустыми строками
     * @return static
     */
    public static function loadFromArray(array $data, $withEmptyStr = true)
    {
        $self = new static();
        foreach ($data as $propertyName => $propertyValue) {
            if (!property_exists($self, $propertyName) || (!$withEmptyStr && $propertyValue == '')) {
                continue;
            }

            $self->$propertyName = $propertyValue;
        }

        return $self;
    }
}