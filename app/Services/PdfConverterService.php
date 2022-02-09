<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfConverterService
{
    private $pdf;
    private StorageService $localStorageService;

    public function __construct()
    {
        $this->localStorageService = new StorageService();
        $this->localStorageService->usingDisk('local');
    }

    public function convertFromUploaded(UploadedFile $file)
    {
        $this->pdf = $file->getContent();
        $version = $this->getPdfVersion();

        if ($version > 1.4) {
            return $this->convertPdfToSafeVersion();
        }

        return [
            'content' => $this->pdf,
            'size' => $file->getSize(),
        ];
    }

    public function convertFromDecoded(string $pdf)
    {
        $this->pdf = $this->localStorageService->getFile($pdf);

        $version = $this->getPdfVersion();

        if ($version > 1.4) {
            return $this->convertPdfToSafeVersion();
        }

        return $pdf;
    }

    private function getPdfVersion()
    {
        $pdfHeader = substr($this->pdf, 0, 20);
        preg_match_all('!\d+!', $pdfHeader, $matches);

        return implode('.', $matches[0]);
    }

    private function convertPdfToSafeVersion()
    {
        $this->checkIfGsIsInstalled();

        $tempPdf = $this->savePdfTemporarily();
        $tempPdfPath = storage_path("app/temp/{$tempPdf}");
        $convertedFileName = "{$tempPdf}-converted.pdf";
        $convertedFilePath = storage_path("app/temp/{$convertedFileName}");

        shell_exec("gs -dBATCH -dAutoRotatePages=/None -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile=\"{$convertedFilePath}\" \"{$tempPdfPath}\"");

        return "temp/{$convertedFileName}";
    }

    private function checkIfGsIsInstalled()
    {
        if (! exec('gs --version')) {
            throw new \Exception('GhostScript is not installed');
        }
    }

    private function savePdfTemporarily()
    {
        return $this->localStorageService->inFolder('temp')
            ->sendContent($this->pdf)
            ->send(false, Str::random(32).'.pdf');
    }
}
