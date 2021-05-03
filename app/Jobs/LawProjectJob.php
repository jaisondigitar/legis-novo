<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\LawsType;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LawProjectJob extends Job implements SelfHandling, ShouldQueue
{

    use InteractsWithQueue;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $types = LawsType::all();

        foreach ($types as $key => $type){
            $job = (new LawProjectExportJob($type))->onQueue('exportLawType');
            dispatch($job);
        }

        $zip = (new LawProjectZipJob())->onQueue('exportLawZip');
        dispatch($zip);

    }
}
