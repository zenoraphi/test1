<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\File;

Schedule::call(function () {
    $tempDir = storage_path('app/temp');
    if (!File::exists($tempDir)) return;

    $files = File::files($tempDir);
    $deleted = 0;
    
    foreach ($files as $file) {
        if ($file->getMTime() < (time() - 3600)) {
            @unlink($file->getPathname());
            $deleted++;
        }
    }
    
    if ($deleted > 0) {
        \Illuminate\Support\Facades\Log::info("Temp cleanup: {$deleted} files deleted");
    }
})->everyFifteenMinutes();