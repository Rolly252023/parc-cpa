<?php

namespace App\Controller;

use App\Service\CsvImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CsvImportController extends AbstractController
{
    #[Route('/import-csv', name: 'csv_import', methods: ['GET', 'POST'])]
    public function index(Request $request, CsvImportService $service): Response
    {
        if ($request->isMethod('POST')) {
            /** @var UploadedFile $file */
            $file = $request->files->get('csv_file');
            if ($file) {
                $path = $this->getParameter('kernel.project_dir').'/var/uploads/'.$file->getClientOriginalName();
                $file->move(dirname($path), basename($path));
                $service->import($path);
                $this->addFlash('success', 'Import réalisé avec succès');
            }
            return $this->redirectToRoute('csv_import');
        }

        return $this->render('csv_import/index.html.twig');
    }
}
