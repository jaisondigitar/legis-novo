<?php

namespace App\Services;

use App\Contracts\UploadInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService implements UploadInterface
{
    protected static $disk = 'digitalocean';

    protected static $file = null;

    private $folder;

    /**
     * @return $this
     */
    public function inAssemblymanFolder(): self
    {
        $this->folder = 'assemblyman';

        return $this;
    }

    /**
     * @return $this
     */
    public function inCompanyFolder(): self
    {
        $this->folder = 'assemblyman';

        return $this;
    }

    /**
     * @return $this
     */
    public function inDocumentsFolder(): self
    {
        $this->folder = 'assemblyman';

        return $this;
    }

    /**
     * @return $this
     */
    public function inLawProjectsFolder(): self
    {
        $this->folder = 'assemblyman';

        return $this;
    }

    /**
     * @param string $folder
     * @return $this
     */
    public function inFolder(string $folder): self
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * @param string $disk
     * @return $this
     */
    public function usingDisk(string $disk): self
    {
        self::$disk = $disk;

        return $this;
    }

    /**
     * @param $file
     * @return UploadService
     */
    public function sendFile($file): self
    {
        static::$file = $file;

        return $this;
    }

    /**
     * @param string $folder
     * @param null $file
     * @return bool
     */
    public function send(string $folder = '', $file = null): bool
    {
        $folder = $this->folder ?? $folder;
        $file = static::$file ?? $file;

        $file = UploadedFile::createFromBase($file);
        $ext = $file->getClientOriginalExtension();
        $filename = Str::random();

        return Storage::disk(self::$disk)
            ->put("{$folder}/{$filename}", $file);
    }
}
