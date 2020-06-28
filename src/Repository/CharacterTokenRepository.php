<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class CharacterTokenRepository
 *
 * @package App\Repository
 *
 * @method CharacterToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterToken[]    findAll()
 * @method CharacterToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterTokenRepository extends ServiceEntityRepository
{
    /**
     * CharacterTokenRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterToken::class);
    }

    /**
     * @param string $username
     *
     * @return CharacterToken[]
     */
    public function findByUsername(string $username): array
    {
        return $this->getBaseQb()
                    ->andWhere('ct.username = :username')
                    ->setParameter('username', $username)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @param string $username
     * @param string $characterId
     *
     * @return CharacterToken|null
     * @throws NonUniqueResultException
     */
    public function findOneByUsernameAndCharacterId(string $username, string $characterId): ?CharacterToken
    {
        return $this->getBaseQb()
                    ->andWhere('ct.username = :username')
                    ->andWhere('c.id = :characterId')
                    ->setParameter('username', $username)
                    ->setParameter('characterId', $characterId)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @param string $username
     * @param int    $eveCharacterId
     *
     * @return CharacterToken|null
     * @throws NonUniqueResultException
     */
    public function findOneByUsernameAndEveCharacterId(string $username, int $eveCharacterId): ?CharacterToken
    {
        return $this->getBaseQb()
                    ->andWhere('ct.username = :username')
                    ->andWhere('c.eveCharacterId = :eveCharacterId')
                    ->setParameter('username', $username)
                    ->setParameter('eveCharacterId', $eveCharacterId)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

    /**
     * @return QueryBuilder
     */
    protected function getBaseQb(): QueryBuilder
    {
        return $this->createQueryBuilder('ct')
                    ->addSelect('ct')
                    ->innerJoin('ct.character', 'c')
                    ->addSelect('c');
    }
}
