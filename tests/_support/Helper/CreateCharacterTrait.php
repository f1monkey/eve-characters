<?php
declare(strict_types=1);

namespace App\Tests\_support\Helper;

use App\Entity\Character;

/**
 * Trait CreateCharacterTrait
 *
 * @package App\Tests\_support\Helper
 */
trait CreateCharacterTrait
{
    /**
     * @param int|null    $eveId
     * @param string|null $eveName
     *
     * @return Character
     */
    public function createCharacter(int $eveId = null, string $eveName = null): Character
    {
        $character = new Character();
        $character->setEveCharacterId($eveId ?? rand(100000, 900000))
                  ->setEveCharacterName($eveName ?? uniqid());

        return $character;
    }
}