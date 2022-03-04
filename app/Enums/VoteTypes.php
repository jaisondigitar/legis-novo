<?php

namespace App\Enums;

class VoteTypes
{
    public const YES = 'yes';
    public const NO = 'no';
    public const BLOCKED = 'blocked';
    public const OUT = 'out';

    public static array $types = [
        self::YES => self::YES,
        self::NO => self::NO,
        self::BLOCKED => self::BLOCKED,
        self::OUT => self::OUT,
    ];
}
