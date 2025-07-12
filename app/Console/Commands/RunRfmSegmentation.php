<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RunRfmSegmentation extends Command
{
    protected $signature = 'run:rfm-segmentation';
    protected $description = 'Run the RFM segmentation Python script';

    public function handle()
    {
        $process = new Process(['py', 'rfm_segmentation.py']);
        $process->setWorkingDirectory(base_path());
        $process->run();
        $this->info('RFM segmentation script executed.');
    }
} 