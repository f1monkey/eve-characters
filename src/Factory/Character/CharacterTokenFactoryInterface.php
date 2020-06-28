<?php
declare(strict_types=1);

namespace App\Factory\Character;

use App\Entity\CharacterToken;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterTokenFactory
 *
 * @package App\Factory\Character
 */
interface CharacterTokenFactoryInterface
{
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
    ): CharacterToken;

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
    ): CharacterToken;
}