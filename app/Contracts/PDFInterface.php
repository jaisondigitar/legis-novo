<?php

namespace App\Contracts;

interface PDFInterface
{
    public function setLocale(array $locales_configs): self;
}
