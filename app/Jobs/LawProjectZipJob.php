<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LawProjectZipJob extends Job implements SelfHandling, ShouldQueue
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    use InteractsWithQueue;

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
        $files = glob(public_path('exportacao/projetoLei'));
        \Chumper\Zipper\Facades\Zipper::make(public_path('exportacao/projetoLei-compactados.zip'))->add($files)->close();
    }
}
