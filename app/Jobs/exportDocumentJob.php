<?php

namespace App\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class exportDocumentJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       foreach ($this->type->documents as $key => $doc){
            $job = (new DocumentExportPDF($doc))->onQueue('exportFile');
            dispatch($job);
        }
    }
}
