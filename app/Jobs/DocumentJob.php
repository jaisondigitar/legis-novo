<?php

namespace App\Jobs;

use App\Models\DocumentType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DocumentJob extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $types = DocumentType::all();

        foreach ($types as $key => $type) {
            $job = (new exportDocumentJob($type))->onQueue('exportType');
            dispatch($job);
        }

        $zip = (new DocumentZipJob())->onQueue('exportDocumentZip');
        dispatch($zip);
    }
}
