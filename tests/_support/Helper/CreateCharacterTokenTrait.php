<?php
declare(strict_types=1);

namespace App\Tests\_support\Helper;

use App\Entity\Character;
use App\Entity\CharacterToken;

/**
 * Trait CreateCharacterTokenTrait
 *
 * @package App\Tests\_support\Helper
 */
trait CreateCharacterTokenTrait
{
    /**
     * @param Character   $character
     * @param string      $username
     * @param string|null $accessToken
     * @param string|null $refreshToken
     *
     * @return CharacterToken
     */
    public function createCharacterToken(
        Character $character,
        string $username = 'user',
        string $accessToken = null,
        string $refreshToken = null
    ): CharacterToken
    {
        $result = new CharacterToken();
        $result->setOwnerHash(uniqid())
               ->setAccessToken($accessToken ?? uniqid())
               ->setRefreshToken($refreshToken ?? uniqid())
               ->setUsername($username)
               ->setCharacter($character);

        return $result;
    }
}