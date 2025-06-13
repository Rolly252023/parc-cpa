<?php

namespace App\Controller\Admin;

use App\Services\DirectoryScanner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Doctrine\DBAL\Connection;


class ImportController extends AbstractController
{
    private $logger;
    private $scanner;

    public function __construct(LoggerInterface $logger, DirectoryScanner $scanner)
    {
        $this->logger = $logger;
        $this->scanner = $scanner;
    }

    #[Route('/admin/import/csv', name: 'app_import_csv')]
    public function importCsv(
        ParameterBagInterface $params,
        Connection $conn
    ): Response {
        // 1) Récupère les fichiers dans le dossier bridge
        $dir   = $params->get('local_bridge_directory');
        $files = $this->scanner->getFileDetails($dir);

        // 2) On interroge MAX(date_import) pour chaque table
        $sql = <<<SQL
            SELECT 'silencieux'          AS table_name, MAX(date_import) AS last_import FROM silencieux
            UNION ALL
            SELECT 'gsa_c5'               AS table_name, MAX(created_at) AS last_import FROM gsa_c5
            UNION ALL
            SELECT 'bridge_ginko_pds'     AS table_name, MAX(created_at) AS last_import FROM bridge_ginko_pds
            SQL;

        $lastImports = $conn
            ->executeQuery($sql)
            ->fetchAllAssociative(); // [ ['table_name'=>'silencieux','last_import'=>'2025-06-13 11:00:00'], … ]

        // 3) On rend le template en lui passant files + lastImports
        return $this->render('admin/import/index.html.twig', [
            'files'       => $files,
            'lastImports' => $lastImports,
        ]);
    }
    #[Route('/admin/files/delete', name: 'file_delete', methods: ['POST'])]
    public function delete(Request $request): JsonResponse
    {
        $filePath = $request->request->get('path');

        $filesystem = new Filesystem();
        if ($filesystem->exists($filePath)) {
            $filesystem->remove($filePath);
            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false, 'message' => 'File not found'], 404);
    }

    #[Route('/admin/imports/bridge/import', name: 'import_python_bridge', methods: ['POST'])]
    public function ImportBridgeByPython(Request $request, KernelInterface $kernel): JsonResponse
    {
        $relativePath = $request->request->get('path');
        dump($relativePath);

        if (!$relativePath) {
            return new JsonResponse(['success' => 'error', 'message' => 'Chemin du fichier manquant.'], 400);
        }

        $projectDir   = $this->getParameter('kernel.project_dir');
        // Le path reçu est du type "/upload/bridge/monfichier.txt"
        $absolutePath = realpath($projectDir . '/public' . $relativePath);

        if (!$absolutePath || !file_exists($absolutePath)) {
            return new JsonResponse([
                'success'  => 'error',
                'message' => 'Fichier introuvable : ' . ($absolutePath ?? $projectDir . '/public' . $relativePath)
            ], 404);
        }

        // on lance la commande Symfony CLI en lui passant le chemin absolu
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'app:import-python-bridge',
            'file'    => $absolutePath,
        ]);

        $output     = new BufferedOutput();
        $returnCode = $application->run($input, $output);
        $content    = $output->fetch();

        if ($returnCode !== Command::SUCCESS) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Erreur lors de l\'import.',
                'details' => $content,
            ], 500);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'Import terminé avec succès.',
            'output'  => $content,
        ]);
    }

    #[Route('/admin/imports/bridge/upload', name: 'upload_bridge_file', methods: ['POST'])]
    public function uploadBridgeFile(Request $request): JsonResponse
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');

        if (!$file) {
            return new JsonResponse(['success' => false, 'message' => 'Aucun fichier reçu'], 400);
        }

        // Valider les extensions autorisées (zip ou csv par exemple)
        $allowedExtensions = ['zip', 'csv', 'txt'];
        $extension = $file->guessExtension();

        if (!in_array($extension, $allowedExtensions)) {
            return new JsonResponse(['success' => false, 'message' => 'Extension non autorisée', $extension], 400);
        }

        // Dossier de destination
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/upload/bridge';
        $filesystem = new Filesystem();
        $filesystem->mkdir($uploadDir);

        // Nom unique du fichier
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = $filename . '-' . uniqid() . '.' . $extension;

        // Déplacement du fichier
        $file->move($uploadDir, $newFilename);

        return new JsonResponse([
            'success' => true,
            'message' => 'Fichier téléchargé avec succès',
            'filepath' => '/upload/bridge/' . $newFilename
        ]);
    }
}
