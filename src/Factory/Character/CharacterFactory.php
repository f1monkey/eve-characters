<?php
declare(strict_types=1);

namespace App\Factory\Character;

use App\Entity\Character;

/**
 * Class CharacterFactory
 *
 * @package App\Factory\Character
 */
class CharacterFactory implements CharacterFactoryInterface
{
    /**
     * @param int    $eveCharacterId
     * @param string $eveCharacterName
     *
     * @return Character
     */
    public function create(int $eveCharacterId, string $eveCharacterName): Character
    {
        $character = new Character();
        $character->setEveCharacterId($eveCharacterId)
                  ->setEveCharacterName($eveCharacterName);

        return $character;
    }
}