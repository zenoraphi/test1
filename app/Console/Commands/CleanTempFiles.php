<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanTempFiles extends Command
{
    protected $signature = 'clean:temp';
    protected $description = 'Clean up temporary files older than 1 hour';

    public function handle()
    {
        $tempDir = storage_path('app/temp');
        
        if (!File::exists($tempDir)) {
            $this->info('Temp directory does not exist.');
            return;
        }
        
        $files = File::files($tempDir);
        $deletedCount = 0;
        
        foreach ($files as $file) {
            // Hapus file yang lebih dari 1 jam
            if (filemtime($file->getPathname()) < (time() - 3600)) {
                @unlink($file->getPathname());
                $deletedCount++;
                $this->info('Deleted: ' . $file->getFilename());
            }
        }
        
        $this->info("Deleted {$deletedCount} temporary files.");
    }
}