<?php

use Faker\Factory as Faker;
use App\Models\DocumentType;
use App\Repositories\DocumentTypeRepository;

trait MakeDocumentTypeTrait
{
    /**
     * Create fake instance of DocumentType and save it in database
     *
     * @param array $documentTypeFields
     * @return DocumentType
     */
    public function makeDocumentType($documentTypeFields = [])
    {
        /** @var DocumentTypeRepository $documentTypeRepo */
        $documentTypeRepo = App::make(DocumentTypeRepository::class);
        $theme = $this->fakeDocumentTypeData($documentTypeFields);
        return $documentTypeRepo->create($theme);
    }

    /**
     * Get fake instance of DocumentType
     *
     * @param array $documentTypeFields
     * @return DocumentType
     */
    public function fakeDocumentType($documentTypeFields = [])
    {
        return new DocumentType($this->fakeDocumentTypeData($documentTypeFields));
    }

    /**
     * Get fake data of DocumentType
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDocumentTypeData($documentTypeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'prefix' => $fake->word,
            'slug' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $documentTypeFields);
    }
}
