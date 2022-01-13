<?php

namespace App\Services;

use App\Contracts\PDFInterface;
use Throwable;

class PDFService implements PDFInterface
{
    public $lib_pdf;

    const DEFAULT_LOCALE = [
        'category' => LC_ALL,
        'locale' => 'pt_BR',
        'locales' => 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese',
    ];

    /**
     * @throws Throwable
     */
    public function __construct($pdf_library)
    {
        $this->lib_pdf = $pdf_library;

        $this->setLocale();
    }

    /**
     * @param  array  $locales_configs
     * @return PDFInterface
     */
    public function setLocale(array $locales_configs = self::DEFAULT_LOCALE): self
    {
        setlocale(
            $locales_configs['category'],
            $locales_configs['locale'],
            $locales_configs['locales']
        );

        return $this;
    }

    /**
     * @param $document
     * @return PDFService
     */
    public function pagesConfigs($document): self
    {
        $this->lib_pdf->pagesConfigs([
            'document_number' => $document->number,
            'document_name' => $document->document_type->name,
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    public function newPage(): self
    {
        $this->lib_pdf->AddPage();

        return $this;
    }

    /**
     * @return $this
     */
    public function writeContent(string $content): self
    {
        $this->lib_pdf->writeHTML($content);

        return $this;
    }

    /**
     * @return string
     */
    public function fileToString(): string
    {
        return $this->lib_pdf->Output(null, 'S');
    }
}
