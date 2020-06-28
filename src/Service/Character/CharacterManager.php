<?php
declare(strict_types=1);

namespace App\Service\Character;

use App\Entity\Character;
use App\Exception\Entity\EntityNotFoundException;
use App\Factory\Character\CharacterFactoryInterface;
use App\Repository\CharacterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class CharacterManager
 *
 * @package App\Service\Character
 */
class CharacterManager implements CharacterManagerInterface
{
    /**
     * @var CharacterRepository
     */
    protected CharacterRepository $characterRepository;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    /**
     * @var CharacterFactoryInterface
     */
    protected CharacterFactoryInterface $characterFactory;

    /**
     * CharacterManager constructor.
     *
     * @param CharacterFactoryInterface $characterFactory
     * @param CharacterRepository       $characterRepository
     * @param EntityManagerInterface    $em
     */
    public function __construct(
        CharacterFactoryInterface $characterFactory,
        CharacterRepository $characterRepository,
        EntityManagerInterface $em
    )
    {
        $this->characterFactory    = $characterFactory;
        $this->characterRepository = $characterRepository;
        $this->em                  = $em;
    }

    /**
     * @param int    $eveCharacterId
     * @param string $eveCharacterName
     *
     * @return Character
     * @throws NonUniqueResultException
     */
    public function getOrCreate(int $eveCharacterId, string $eveCharacterName): Character
    {
        try {
            $character = $this->getByEveCharacterId($eveCharacterId);
            $character->setEveCharacterName($eveCharacterName);
            $this->save($character);
        } catch (EntityNotFoundException $e) {
            $character = $this->create($eveCharacterId, $eveCharacterName);
        }

        return $character;
    }

    /**
     * @param int $eveCharacterId
     *
     * @return Character
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     */
    public function getByEveCharacterId(int $eveCharacterId): Character
    {
        $result = $this->characterRepository->findOneByEveCharacterId($eveCharacterId);
        if ($result === null) {
            throw new EntityNotFoundException(
                sprintf('Character with eve id "%s" not found', $eveCharacterId)
            );
        }

        return $result;
    }

    /**
     * @param int    $eveCharacterId
     * @param string $eveCharacterName
     *
     * @return Character
     */
    public function create(int $eveCharacterId, string $eveCharacterName): Character
    {
        $character = $this->characterFactory->create($eveCharacterId, $eveCharacterName);
        $this->save($character);

        return $character;
    }

    /**
     * @param Character $character
     */
    public function save(Character $character): void
    {
        $this->em->persist($character);
        $this->em->flush();
    }
}