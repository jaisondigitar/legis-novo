<?php

namespace App\Services;

use App\Contracts\StorageInterface;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class StorageService implements StorageInterface
{
    protected $disk = 'digitalocean';

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
     * @return $this
     */
    public function inPeopleFolder(): self
    {
        $this->folder = 'people';

        return $this;
    }

    /**
     * @return $this
     */
    public function inAdvicesFolder(): self
    {
        $this->folder = 'advices';

        return $this;
    }

    /**
     * @return $this
     */
    public function inLawsFolder(): self
    {
        $this->folder = 'laws';

        return $this;
    }

    /**
     * @return $this
     */
    public function inMeetingsFolder(): self
    {
        $this->folder = 'meetings';

        return $this;
    }

    /**
     * @return $this
     */
    public function inImageProfileFolder(): self
    {
        $this->folder = 'images/profile';

        return $this;
    }

    /**
     * @param string $folder
     * @return $this
     */
    public function inFolder(string $folder): self
    {
        ! Storage::exists($folder) && Storage::makeDirectory($folder);

        $this->folder = $folder;

        return $this;
    }

    /**
     * @param string $disk
     * @return $this
     */
    public function usingDisk(string $disk): self
    {
        $this->disk = $disk;

        return $this;
    }

    /**
     * @param $file
     * @return StorageService
     */
    public function sendFile($file): self
    {
        static::$file = $file;

        static::$ext = static::$file->getClientOriginalExtension();

        return $this;
    }

    /**
     * @param  string  $content
     * @param  string  $ext
     * @return $this
     */
    public function sendContent(string $content, string $ext = 'pdf'): self
    {
        static::$file = $content;

        static::$ext = $ext;

        return $this;
    }

    /**
     * @param  bool  $custom
     * @param  string  $filename
     * @return string
     * @throws Throwable
     */
    public function send(bool $custom = true, string $filename = ''): string
    {
        $filename = Str::random(32).'.'.static::$ext;

        if ($custom) {
            $resp = Storage::disk($this->disk)
                ->putFileAs($this->folder, static::$file, $filename, Filesystem::VISIBILITY_PUBLIC);
        } else {
            $resp = Storage::disk($this->disk)
                ->put($this->folder.'/'.$filename, static::$file, Filesystem::VISIBILITY_PUBLIC);
        }

        throw_if(! $resp, new Exception('Falha ao salvar arquivo'));

        return $filename;
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getPath(string $filename): string
    {
        $file_name = $this->folder ? "{$this->folder}/{$filename}" : $filename;

        if ($this->isDocument($filename)) {
            return Storage::disk($this->disk)->url("app/{$file_name}");
        }

        return Storage::disk($this->disk)->url("{$file_name}");
    }

    /**
     * @param  string  $filename
     * @return string
     * @throws FileNotFoundException
     */
    public function getFile(string $filename): string
    {
        $file_name = $this->folder ? "{$this->folder}/{$filename}" : $filename;

        return Storage::disk($this->disk)->get($file_name);
    }

    public function isDocument(string $filename): bool
    {
        return Str::endsWith($filename, ['.pdf', '.doc', '.docx', '.txt']);
    }

    /**
     * @param  string  $filename
     * @return $this
     */
    public function removeOne(string $filename): self
    {
        Storage::disk($this->disk)->delete("{$this->folder}/{$filename}");

        return $this;
    }

    /**
     * @param  array  $filenames
     * @return $this
     */
    public function removeMany(array $filenames): self
    {
        foreach ($filenames as $file) {
            Storage::disk($this->disk)->delete("{$this->folder}/{$file}");
        }

        return $this;
    }
}
