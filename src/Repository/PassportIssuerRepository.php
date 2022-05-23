<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\PassportIssuer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PassportIssuer|null find($id, $lockMode = null, $lockVersion = null)
 * @method PassportIssuer|null findOneBy(array $criteria, array $orderBy = null)
 * @method PassportIssuer[]    findAll()
 * @method PassportIssuer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassportIssuerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PassportIssuer::class);
    }

    public function fetchFromFilters(?int $passportCode)
    {
        $qb = $this->createQueryBuilder('i');

        if ($passportCode) {
            $qb->andWhere('i.passportCode = :passportCode');
            $qb->setParameter('passportCode', $passportCode);
        }

        $qb->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }
}
