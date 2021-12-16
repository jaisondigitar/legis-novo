<?php

namespace App\Enums;

class DocumentStatuses
{
    public const OPENED = 1;
    public const PROTOCOLED = 2;

    public static array $statuses = [
        self::OPENED,
        self::PROTOCOLED,
    ];
}
