<?php

namespace App\Services;

use App\Contracts\StorageInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class StorageService implements StorageInterface
{
    protected static $disk = 'digitalocean';

    protected static $file = null;

    protected static $ext = null;

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
        $this->folder = 'company';

        return $this;
    }

    /**
     * @return $this
     */
    public function inDocumentsFolder(): self
    {
        $this->folder = 'documents';

        return $this;
    }

    /**
     * @return $this
     */
    public function inLawProjectsFolder(): self
    {
        $this->folder = 'law-projects';

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
     * @return StorageService
     */
    public function sendFile($file): self
    {
        static::$file = $file;

        return $this;
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function send(): string
    {
        static::$ext = static::$file->getClientOriginalExtension();

        $filename = Str::random(32).'.'.static::$ext;

        $resp = Storage::disk(self::$disk)
            ->putFileAs($this->folder, static::$file, $filename, 'public');

        throw_if(! $resp, new Exception('Falha ao salvar arquivo'));

        return $filename;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function get(string $filename): string
    {
        return Storage::disk(self::$disk)->url("{$this->folder}/{$filename}");
    }
}
