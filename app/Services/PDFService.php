<?php

namespace App\Services;

use App\Contracts\PDFInterface;

class PDFService implements PDFInterface
{
    const DEFAULT_LOCALE = [
        'category' => LC_ALL,
        'locale' => 'pt_BR',
        'locales' => 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese',
    ];

    public function setLocale(array $locales_configs = self::DEFAULT_LOCALE): PDFInterface
    {
        setlocale(
            $locales_configs['category'],
            $locales_configs['locale'],
            $locales_configs['locales']
        );

        return $this;
    }
}
