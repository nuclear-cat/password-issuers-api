<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\PassportIssuerV2;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ImportV2Command extends Command
{
    protected static $defaultName = 'app:import-v2';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output = new ConsoleOutput();

        $file = __DIR__ . '/../../dictionary_v2.csv';

        $fileContent = file_get_contents($file);
        $fileLines = explode(PHP_EOL, $fileContent);
//        $totalLines = count($fileLines);

        $stmt = $this->entityManager->getConnection()->prepare('DELETE FROM passport_issuer_v2 e WHERE 1 = 1');
        $stmt->executeQuery();

        $i = 0;
        foreach ($fileLines as $key => $line) {
            $i++;
            if ($i === 1) {
                continue;
            }

            $output->writeln($line);
            $data = str_getcsv($line, ';');
//            $lineNumber = $key + 1;

            if (!isset($data[0]) || empty($data[0])) {
                continue;
            }

            $id = (int)$data[0];
            $code = $data[1];
            $name = $data[2];
            $endDate = !empty($data[3]) ? new \DateTimeImmutable($data[3]) : null;

            $passportIssuerV2 = (new PassportIssuerV2(
                $id,
                $code,
                $name,
            ))->setEndDate($endDate);

            $this->entityManager->persist($passportIssuerV2);

            $this->entityManager->flush();
        }

        return 1;
    }
}