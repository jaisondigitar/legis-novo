<?php

namespace App\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class PdfConverterService
{
    /**
     * @var
     */
    private $pdf;

    /**
     * @var StorageService
     */
    private StorageService $localStorageService;

    public function __construct()
    {
        $this->localStorageService = new StorageService();
        $this->localStorageService->usingDisk('local');
    }

    /**
     * @param  UploadedFile  $file
     * @return array|string
     * @throws Throwable
     */
    public function convertFromUploaded(UploadedFile $file)
    {
        ! Storage::exists('temp') && Storage::makeDirectory('temp');

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

    /**
     * @param  string  $pdf
     * @return string
     * @throws FileNotFoundException|Throwable
     */
    public function convertFromDecoded(string $pdf): string
    {
        $this->pdf = $this->localStorageService->getFile($pdf);

        $version = $this->getPdfVersion();

        if ($version > 1.4) {
            return $this->convertPdfToSafeVersion();
        }

        return $pdf;
    }

    /**
     * @return string
     */
    private function getPdfVersion(): string
    {
        $pdfHeader = substr($this->pdf, 0, 20);
        preg_match_all('!\d+!', $pdfHeader, $matches);

        return implode('.', $matches[0]);
    }

    /**
     * @return string
     * @throws Exception|Throwable
     */
    private function convertPdfToSafeVersion(): string
    {
        $this->checkIfGsIsInstalled();

        $tempPdf = $this->savePdfTemporarily();
        $tempPdfPath = storage_path("app/temp/{$tempPdf}");
        $convertedFileName = "{$tempPdf}-converted.pdf";
        $convertedFilePath = storage_path("app/temp/{$convertedFileName}");

        shell_exec("gs -dBATCH -dAutoRotatePages=/None -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile=\"{$convertedFilePath}\" \"{$tempPdfPath}\"");

        return "temp/{$convertedFileName}";
    }

    /**
     * @return void
     * @throws Exception
     */
    private function checkIfGsIsInstalled()
    {
        if (! exec('gs --version')) {
            throw new Exception('GhostScript is not installed');
        }
    }

    /**
     * @return string
     * @throws Throwable
     */
    private function savePdfTemporarily(): string
    {
        return $this->localStorageService->inFolder('temp')
            ->sendContent($this->pdf)
            ->send(false, Str::random(32).'.pdf');
    }
}
