<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Style\SymfonyStyle;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:import-python-bridge',
    description: 'Importe un fichier ZIP ou TXT en appelant le bon script Python',
)]
class ImportPythonBridgeCommand extends Command
{
    private LoggerInterface $logger;
    private string $projectDir;

    public function __construct(
        #[Autowire('%kernel.project_dir%')] string $projectDir,
        LoggerInterface $logger
    ) {
        parent::__construct();
        $this->projectDir = $projectDir;
        $this->logger = $logger;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('file', InputArgument::REQUIRED, 'Nom du fichier (ex : 026_C5_par_Poste-xxx.txt)')
            // ← on ajoute les options limit et offset
            ->addOption('limit',  'l', InputOption::VALUE_OPTIONAL, 'Nombre maximal de lignes à traiter', null)
            ->addOption('offset', 'o', InputOption::VALUE_OPTIONAL, 'Nombre de lignes à sauter avant traitement', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io         = new SymfonyStyle($input, $output);
        $fileArg    = $input->getArgument('file');
        $limit      = $input->getOption('limit');
        $offset     = $input->getOption('offset');
        $projectDir = $this->projectDir;
        $fs         = new Filesystem();
        // 1) tentative de path absolu pur ou relatif
        if (file_exists($fileArg)) {
            $filePath = realpath($fileArg);
        } else {
            $uploadDir = $projectDir . '/public/upload/bridge';
            $candidate = $uploadDir . DIRECTORY_SEPARATOR . basename($fileArg);
            $filePath  = realpath($candidate);

            // 2) fallback par motif
            if (!$filePath) {
                $pattern = $uploadDir . DIRECTORY_SEPARATOR . '*' . basename($fileArg) . '*';
                $matches = glob($pattern);
                if (count($matches) > 0) {
                    $filePath = realpath($matches[0]);
                }
            }
        }

        if (!$filePath) {
            $io->error("Fichier introuvable : $fileArg");
            return Command::FAILURE;
        }

        $this->logger->info("Début de l'import via app:import-python-bridge", ['fichier' => $filePath]);


        // 2) choix du script Python
        $filename = pathinfo($filePath, PATHINFO_FILENAME);
        $scriptMap = [
            'im_ginko_pds_ddr' => 'import_ginko_pds.py',
            'im_bdp_reclamations' => 'import_reclamations.py',
            'im_gko_taches_bloquantes_en_cours_cen' => 'import_taches.py',
            'C5_par_Poste'     => 'import_gsa.py',
            'priorisation'     => 'import_silencieux.py',
            'Capella'     => 'import_capella.py',
        ];

        $matchedScript = null;
        foreach ($scriptMap as $pattern => $script) {
            if (stripos($filename, $pattern) !== false) {
                $matchedScript = $script;
                break;
            }
        }
        if (!$matchedScript) {
            $message = "Aucun script Python pour '$filename'";
            $io->error($message);
            $this->logger->error($message);
            return Command::FAILURE;
        }

        // 3) chemin absolu vers le script Python
        $pythonScriptPath = $this->projectDir
            . DIRECTORY_SEPARATOR . 'src'
            . DIRECTORY_SEPARATOR . 'Command'
            . DIRECTORY_SEPARATOR . 'python'
            . DIRECTORY_SEPARATOR . $matchedScript;

        if (!file_exists($pythonScriptPath)) {
            $message = "Script Python introuvable : $pythonScriptPath";
            $io->error($message);
            $this->logger->error($message);
            return Command::FAILURE;
        }

        $venvPython = $this->projectDir
            . DIRECTORY_SEPARATOR . 'venv'
            . DIRECTORY_SEPARATOR . 'Scripts'
            . DIRECTORY_SEPARATOR . 'python.exe';

        if (file_exists($venvPython)) {
            $pythonBinary = $venvPython;
            $this->logger->info("Utilisation du Python du venv : $pythonBinary");
        } else {
            // fallback si vous n'avez pas de venv (ex. en prod)
            $pythonBinary = '/usr/bin/python3';
            $this->logger->warning("venv non trouvé, utilisation du 'python' global");
        }

        // 5) variables d’environnement à passer au script
        $env = [
            'DB_USER'     => $_ENV['DATABASE_USER']     ?? 'root',
            'DB_PASSWORD' => $_ENV['DATABASE_PASSWORD'] ?? '',
            'DB_HOST'     => $_ENV['DATABASE_HOST']     ?? 'localhost',
            'DB_NAME'     => $_ENV['DATABASE_NAME']     ?? 'parc-cpa',
            'PROJECT_DIR' => $this->projectDir,
        ];
        // construction de la ligne de commande
        $args = [
            $pythonBinary,
            $pythonScriptPath,
            $filePath,
        ];
        if (null !== $limit) {
            $args[] = '--limit';
            $args[] = $limit;
        }
        if (null !== $offset) {
            $args[] = '--offset';
            $args[] = $offset;
        }

        $this->logger->info("Lancement du process :", ['cmd' => implode(' ', $args)]);
        $io->info("start");
        // 6) exécution
        $process = new Process(
            [$pythonBinary, $pythonScriptPath, $filePath],
            // on fixe le cwd au projet pour les imports relatifs
            $this->projectDir,
            $env
        );
        $process->setTimeout(3000);
        $process->run();

        $io->info($filePath);
        $io->info("fin process");

        if (!$process->isSuccessful()) {
            $message = "Erreur dans le script Python l125 :\n"
                . $process->getErrorOutput()
                . $process->getOutput();
            $io->error($message);
            $this->logger->error($message);
            return Command::FAILURE;
        }

        // 1) Log du succès
        $this->logger->info('Script Python terminé avec succès', [
            'output' => $process->getOutput()
        ]);
        $io->success('Import terminé : ' . $process->getOutput());

        // 2) Suppression du fichier importé (sauf si c'est un ZIP)
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if ($extension !== 'zip') {
            try {
                if ($fs->exists($filePath)) {
                    $fs->remove($filePath);
                    $this->logger->info("Fichier bridge supprimé : $filePath");
                }
            } catch (\Exception $e) {
                // en cas d’erreur de suppression, on log simplement
                $this->logger->warning(
                    "Impossible de supprimer le fichier après import : {$filePath}",
                    ['exception' => $e->getMessage()]
                );
            }
        } else {
            $this->logger->info("Fichier ZIP conservé : $filePath");
        }


        return Command::SUCCESS;
    }
}
