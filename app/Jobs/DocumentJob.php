<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use PhpParser\Comment\Doc;

class DocumentJob extends Job implements SelfHandling, ShouldQueue
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

        foreach ($types as $key => $type){
            $job = (new exportDocumentJob($type))->onQueue('exportType');
            dispatch($job);
        }

        $zip = (new DocumentZipJob())->onQueue('exportDocumentZip');
        dispatch($zip);
    }
}
