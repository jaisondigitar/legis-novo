<?php

namespace App\Services;

use App\Contracts\StorageInterface;
use Exception;
use Illuminate\Http\UploadedFile;

class PdfConverterService
{
    /**
     * @var
     */
    private $pdf;

    /**
     * @var StorageInterface
     */
    private StorageInterface $localStorageService;

    /**
     * @param  StorageInterface  $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->localStorageService = $storage;
        $this->localStorageService->usingDisk('local');
    }

    /**
     * @param  UploadedFile  $file
     * @return string
     * @throws Exception
     */
    public function convertFromUploaded(UploadedFile $file): string
    {
        $this->pdf = $file->getContent();
        $version = $this->getPdfVersion();

        if ($version > 1.4) {
            return $this->convertPdfToSafeVersion();
        }

        return $this->pdf;
    }

    /**
     * @param  string  $pdf
     * @return string
     * @throws Exception
     */
    public function convertFromDecoded(string $pdf): string
    {
        $file = (new StorageService())->usingDisk('local')->getFile($pdf);

        $this->pdf = $file;
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
     * @throws Exception
     */
    private function convertPdfToSafeVersion(): string
    {
        $this->checkIfGsIsInstalled();

        $tempPdf = $this->savePdfTemporarily();
        $tempPdfPath = base_path().$this->localStorageService->inFolder('temp')
                ->getPath($tempPdf);
        $convertedFileName = "{$tempPdf}-converted.pdf";
        $convertedFilePath = base_path().$this->localStorageService->inFolder('temp')
            ->getPath($convertedFileName);

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
     * @return mixed
     */
    private function savePdfTemporarily()
    {
        return $this->localStorageService->inFolder('temp')
            ->sendContent($this->pdf)
            ->send(false);
    }
}
