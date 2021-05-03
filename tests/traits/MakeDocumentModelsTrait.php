<?php

use Faker\Factory as Faker;
use App\Models\DocumentModels;
use App\Repositories\DocumentModelsRepository;

trait MakeDocumentModelsTrait
{
    /**
     * Create fake instance of DocumentModels and save it in database
     *
     * @param array $documentModelsFields
     * @return DocumentModels
     */
    public function makeDocumentModels($documentModelsFields = [])
    {
        /** @var DocumentModelsRepository $documentModelsRepo */
        $documentModelsRepo = App::make(DocumentModelsRepository::class);
        $theme = $this->fakeDocumentModelsData($documentModelsFields);
        return $documentModelsRepo->create($theme);
    }

    /**
     * Get fake instance of DocumentModels
     *
     * @param array $documentModelsFields
     * @return DocumentModels
     */
    public function fakeDocumentModels($documentModelsFields = [])
    {
        return new DocumentModels($this->fakeDocumentModelsData($documentModelsFields));
    }

    /**
     * Get fake data of DocumentModels
     *
     * @param array $postFields
     * @return array
     */
    public function fakeDocumentModelsData($documentModelsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'document_type_id' => $fake->randomDigitNotNull,
            'name' => $fake->word,
            'content' => $fake->text,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $documentModelsFields);
    }
}
