<?php

namespace App\Contracts;

interface StorageInterface
{
    public function inAssemblymanFolder();

    public function inCompanyFolder();

    public function inDocumentsFolder();

    public function inLawProjectsFolder();

    public function inPeopleFolder();

    public function inAdvicesFolder();

    public function inLawsFolder();

    public function inMeetingsFolder();

    public function inImageProfileFolder();

    public function inFolder(string $folder);

    public function usingDisk(string $disk);

    public function sendFile($file);

    public function sendContent(string $content, string $ext = '.pdf');

    public function send(bool $custom = true, string $filename = '');

    public function getPath(string $filename);

    public function getFile(string $filename);

    public function removeOne(string $filename);

    public function removeMany(array $filenames);
}
