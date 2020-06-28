<?php
declare(strict_types=1);

namespace App\Service\Character;

use App\Entity\Character;
use App\Exception\Entity\EntityNotFoundException;

/**
 * Interface CharacterManagerInterface
 *
 * @package App\Service\Character
 */
interface CharacterManagerInterface
{
    /**
     * @param int    $eveCharacterId
     * @param string $eveCharacterName
     *
     * @return Character
     */
    public function getOrCreate(int $eveCharacterId, string $eveCharacterName): Character;

    /**
     * @param int $eveCharacterId
     *
     * @return Character
     * @throws EntityNotFoundException
     */
    public function getByEveCharacterId(int $eveCharacterId): Character;

    /**
     * @param int    $eveCharacterId
     * @param string $eveCharacterName
     *
     * @return Character
     */
    public function create(int $eveCharacterId, string $eveCharacterName): Character;

    /**
     * @param Character $character
     */
    public function save(Character $character): void;
}