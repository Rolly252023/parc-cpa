<?php

namespace App\Services;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

class DirectoryScanner
{
    private $filesystem;

    public function __construct()
    {
        $this->filesystem = new Filesystem();
    }

    /**
     * Récupère les détails des fichiers dans un répertoire
     * 
     * @param string $directory Le chemin du répertoire à scanner
     * @return array Les détails des fichiers
     */
    public function getFileDetails(string $directory): array
    {
        if (!$this->filesystem->exists($directory)) {
            return [];
        }

        $finder = new Finder();
        $finder->files()->in($directory);

        $files = [];
        foreach ($finder as $file) {
            $files[] = [
                'name' => $file->getFilename(),
                'path' => $file->getPathname(),
                'relativePath' => '/upload/bridge/' . $file->getFilename(),
                'size' => $this->formatFileSize($file->getSize()),
                'extension' => $file->getExtension(),
                'lastModified' => $file->getMTime(),
                'lastModifiedFormatted' => date('d/m/Y H:i:s', $file->getMTime()),
            ];
        }

        return $files;
    }

    /**
     * Formate la taille du fichier en unités lisibles
     * 
     * @param int $bytes Taille en octets
     * @return string Taille formatée
     */
    private function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
} 