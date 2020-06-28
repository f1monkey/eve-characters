<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CharacterRepository
 *
 * @package App\Repository
 *
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    /**
     * CharacterRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * @param int $eveCharacterId
     *
     * @return Character|null
     * @throws NonUniqueResultException
     */
    public function findOneByEveCharacterId(int $eveCharacterId): ?Character
    {
        return $this->getBaseQb()
                    ->andWhere('c.eveCharacterId = :eveCharacterId')
                    ->setParameter('eveCharacterId', $eveCharacterId)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @return QueryBuilder
     */
    protected function getBaseQb(): QueryBuilder
    {
        return $this->createQueryBuilder('c')->addSelect('c');
    }
}
