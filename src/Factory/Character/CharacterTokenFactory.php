<?php
declare(strict_types=1);

namespace App\Factory\Character;

use App\Entity\CharacterToken;
use App\Service\Character\CharacterManagerInterface;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterTokenFactory
 *
 * @package App\Factory\Character
 */
class CharacterTokenFactory implements CharacterTokenFactoryInterface
{
    /**
     * @var CharacterManagerInterface
     */
    protected CharacterManagerInterface $characterManager;

    /**
     * CharacterTokenFactory constructor.
     *
     * @param CharacterManagerInterface $characterManager
     */
    public function __construct(CharacterManagerInterface $characterManager)
    {
        $this->characterManager = $characterManager;
    }

    /**
     * @param UserInterface             $user
     * @param TokenResponse             $tokenResponse
     * @param VerifyAccessTokenResponse $accessTokenResponse
     *
     * @return CharacterToken
     */
    public function createFromEsiData(
        UserInterface $user,
        TokenResponse $tokenResponse,
        VerifyAccessTokenResponse $accessTokenResponse
    ): CharacterToken
    {
        $result = new CharacterToken();
        $result->setUsername($user->getUsername())
               ->setAccessToken($tokenResponse->getAccessToken())
               ->setRefreshToken($tokenResponse->getRefreshToken())
               ->setOwnerHash($accessTokenResponse->getOwnerHash())
               ->setCharacter(
                   $this->characterManager->getOrCreate(
                       $accessTokenResponse->getCharacterId(),
                       $accessTokenResponse->getCharacterName()
                   )
               );

        return $result;
    }

    /**
     * @param CharacterToken            $characterToken
     * @param TokenResponse             $tokenResponse
     * @param VerifyAccessTokenResponse $accessTokenResponse
     *
     * @return CharacterToken
     */
    public function fillFromEsiData(
        CharacterToken $characterToken,
        TokenResponse $tokenResponse,
        VerifyAccessTokenResponse $accessTokenResponse
    ): CharacterToken
    {
        $characterToken->setAccessToken($tokenResponse->getAccessToken())
                       ->setRefreshToken($tokenResponse->getRefreshToken())
                       ->setOwnerHash($accessTokenResponse->getOwnerHash())
                       ->setCharacter(
                           $this->characterManager->getOrCreate(
                               $accessTokenResponse->getCharacterId(),
                               $accessTokenResponse->getCharacterName()
                           )
                       );

        return $characterToken;
    }
}