<?php

namespace App\Service;

use Symfony\Component\Process\Process;

class CsvImportService
{
    public function import(string $path): void
    {
        $process = new Process(['python3', __DIR__.'/../../bin/csv_import.py', $path]);
        $process->setTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('CSV import failed: '.$process->getErrorOutput());
        }
    }
}
