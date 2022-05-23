<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\PassportIssuer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ImportV1Command extends Command
{
    protected static $defaultName = 'app:import-v1';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();

        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output = new ConsoleOutput();

        $file = __DIR__ . '/../../dictionary.csv';

        $fileContent = mb_convert_encoding(file_get_contents($file), 'utf-8', 'cp-1251');
        $fileLines = explode(PHP_EOL, $fileContent);
        $totalLines = count($fileLines);

        $stmt = $this->entityManager->getConnection()->prepare('DELETE FROM passport_issuer e WHERE 1 = 1');
        $stmt->executeQuery();

        foreach ($fileLines as $key => $line) {
            $output->writeln($line);
            $data = str_getcsv($line, ';');
            $lineNumber = $key + 1;

            if (!(isset($data[0]) && $data[0] > 0)) {
                continue;
            }

            $issuer = new PassportIssuer();

            $issuer->setId((int)$data[0]);
            $issuer->setIssuedBy((string)$data[1]);
            $issuer->setIssuerCode((string)$data[2]);

            $issuer->setPassportCode((string)$data[3]);
            $issuer->setCbduigCode((string)$data[4]);
            $issuer->setRegionId((string)$data[5]);

            $output->writeln("({$lineNumber}/{$totalLines}) {$issuer->getId()}, {$issuer->getIssuedBy()}, {$issuer->getIssuerCode()}, {$issuer->getPassportCode()}, {$issuer->getCbduigCode()}, {$issuer->getRegionId()}  adding...");
            $this->entityManager->persist($issuer);
            $output->writeln("OK");

            $this->entityManager->flush();
        }

        return 1;
    }
}