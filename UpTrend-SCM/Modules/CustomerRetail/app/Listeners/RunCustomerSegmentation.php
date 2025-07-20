<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\Process\Process;

class RunCustomerSegmentation implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(OrderPlaced $event)
    {
        $process = new Process(['py', 'rfm_segmentation.py']);
        $process->setWorkingDirectory(base_path());
        $process->start(); // Non-blocking, runs in the background
    }
}
