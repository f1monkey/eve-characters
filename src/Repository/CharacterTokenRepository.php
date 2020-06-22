<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\CharacterToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}
