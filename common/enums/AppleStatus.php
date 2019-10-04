<?php


namespace common\enums;

/**
 * Class AppleStatus
 *
 * @package common\enums
 */
class AppleStatus extends BasicEnum
{
    const ON_TREE = 'on_tree';
    const FELL = 'fell';
    const ROTTEN = 'rotten';

    const __default = self::ON_TREE;

    protected static function labels()
    {
        return [
            self::ON_TREE => 'On tree',
            self::FELL => 'Fell',
            self::ROTTEN => 'Rotten'
        ];
    }
}
