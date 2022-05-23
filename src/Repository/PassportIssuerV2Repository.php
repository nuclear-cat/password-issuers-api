<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\PassportIssuerV2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PassportIssuerV2|null find($id, $lockMode = null, $lockVersion = null)
 * @method PassportIssuerV2|null findOneBy(array $criteria, array $orderBy = null)
 * @method PassportIssuerV2[]    findAll()
 * @method PassportIssuerV2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassportIssuerV2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PassportIssuerV2::class);
    }

    public function fetchFromFilters(?string $code)
    {
        $qb = $this->createQueryBuilder('i');

        if ($code) {
            $qb->andWhere('i.code = :code');
            $qb->setParameter('code', $code);
        }

        $qb->setMaxResults(10);

        return $qb->getQuery()->getResult();
    }
}
