<?php

namespace App\Contracts;

interface PDFInterface
{
    /**
     * @param  array  $locales_configs
     * @return $this
     */
    public function setLocale(array $locales_configs): self;

    /**
     * @param $document
     * @return $this
     */
    public function pagesConfigs($document): self;

    /**
     * @return $this
     */
    public function newPage(): self;

    /**
     * @return $this
     */
    public function writeContent(string $content): self;

    /**
     * @return string
     */
    public function fileToString(): string;
}
