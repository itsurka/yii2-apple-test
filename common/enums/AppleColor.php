<?php


namespace common\enums;


class AppleColor extends BasicEnum
{
    const RED = 'red';
    const GREEN = 'green';
    const YELLOW = 'yellow';

    protected static function labels()
    {
        return [
            self::RED => 'Red',
            self::GREEN => 'Green',
            self::YELLOW => 'Yellow'
        ];
    }
}
