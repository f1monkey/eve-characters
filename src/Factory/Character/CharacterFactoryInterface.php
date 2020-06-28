<?php
declare(strict_types=1);

namespace App\Factory\Character;

use App\Entity\Character;

/**
 * Interface CharacterFactoryInterface
 *
 * @package App\Factory\Character
 */
interface CharacterFactoryInterface
{
    /**
     * @param int    $eveCharacterId
     * @param string $eveCharacterName
     *
     * @return Character
     */
    public function create(int $eveCharacterId, string $eveCharacterName): Character;
}