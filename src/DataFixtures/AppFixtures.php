<?php

namespace App\DataFixtures;

use App\Entity\PassportIssuer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Output\ConsoleOutput;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $output = new ConsoleOutput();

        $file = __DIR__ . '/../../dictionary.csv';

        $fileContent = mb_convert_encoding(file_get_contents($file), 'utf-8', 'cp-1251');
        $fileLines = explode(PHP_EOL, $fileContent);
        $totalLines = count($fileLines);

        foreach ($fileLines as $key => $line) {
            $output->writeln($line);
            $data = str_getcsv($line, ';');
            $lineNumber = $key + 1;

            if (!(isset($data[0]) && $data[0] > 0)) {
                continue;
            }

            $issuer = new PassportIssuer();

            $issuer->setId((int) $data[0]);
            $issuer->setIssuedBy((string) $data[1]);
            $issuer->setIssuerCode((string) $data[2]);

            $issuer->setPassportCode((int) $data[3]);
            $issuer->setCbduigCode((int) $data[4]);
            $issuer->setRegionId((int) $data[5]);

            $output->writeln("({$lineNumber}/{$totalLines}) {$issuer->getId()}, {$issuer->getIssuedBy()}, {$issuer->getIssuerCode()}, {$issuer->getPassportCode()}, {$issuer->getCbduigCode()}, {$issuer->getRegionId()}  adding...");
            $manager->persist($issuer);
            $output->writeln("OK");
        }

        $manager->flush();
    }
}
