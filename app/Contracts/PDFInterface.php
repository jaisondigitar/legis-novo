<?php

namespace App\Contracts;

interface PDFInterface
{
    /**
     * @param  array  $locales_configs
     * @return $this
     */
    public function setLocale(array $locales_configs): self;
}
