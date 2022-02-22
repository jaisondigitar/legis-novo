<?php

namespace App\Enums;

use App\Models\Advice;
use App\Models\Document;
use App\Models\LawsProject;

class DocumentTypes
{
    public const DOCUMENT = 'document';
    public const LAW_PROJECT = 'law_project';
    public const ADVICE = 'advice';

    public static array $types = [
        Document::class => self::DOCUMENT,
        LawsProject::class => self::LAW_PROJECT,
        Advice::class => self::ADVICE,
    ];
}
