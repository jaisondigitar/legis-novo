<?php

namespace App\Contracts;

interface StorageInterface
{
    public function inAssemblymanFolder();

    public function inCompanyFolder();

    public function inDocumentsFolder();

    public function inLawProjectsFolder();

    public function inPeopleFolder();

    public function inFolder(string $folder);

    public function usingDisk(string $disk);

    public function sendFile($file);

    public function send();

    public function get(string $filename);
}
