<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LawProjectExportJob extends Job implements SelfHandling, ShouldQueue
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
        foreach ($this->type->laws as $key => $law){
            $job = (new LawProjectExportPDFJob($law))->onQueue('exportLawFile');
            dispatch($job);
        }
    }
}
