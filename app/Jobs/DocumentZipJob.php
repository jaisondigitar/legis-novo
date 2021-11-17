<?php

namespace App\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Madnest\Madzipper\Madzipper;

class DocumentZipJob extends Job implements ShouldQueue
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
     * @throws Exception
     */
    public function handle()
    {
        $files = glob(public_path('exportacao/documentos'));
        (new Madzipper)->make(public_path('exportacao/documentos-compactados.zip'))->add($files)->close();
    }
}
