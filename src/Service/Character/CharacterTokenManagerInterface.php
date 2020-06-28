<?php
declare(strict_types=1);

namespace App\Service\Character;

use App\Entity\CharacterToken;
use App\Exception\Entity\EntityNotFoundException;
use Doctrine\Common\Collections\Collection;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterTokenManager
 *
 * @package App\Service\Character
 */
interface CharacterTokenManagerInterface
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
     * @param UserInterface $user
     *
     * @return Collection<int, CharacterToken>
     */
    public function getByUser(UserInterface $user): Collection;

    /**
     * @param UserInterface $user
     * @param string        $characterId
     *
     * @return CharacterToken
     * @throws EntityNotFoundException
     */
    public function getByUserAndCharacter(UserInterface $user, string $characterId): CharacterToken;

    /**
     * @param UserInterface $user
     * @param int           $eveCharacterId
     *
     * @return CharacterToken
     * @throws EntityNotFoundException
     */
    public function getByUserAndEveCharacterId(UserInterface $user, int $eveCharacterId): CharacterToken;

    /**
     * @param CharacterToken $characterToken
     */
    public function save(CharacterToken $characterToken): void;
}