<?php
declare(strict_types=1);

namespace App\Service\Character;

use App\Entity\CharacterToken;
use App\Exception\Entity\EntityNotFoundException;
use Doctrine\Common\Collections\Collection;
use F1monkey\EveEsiBundle\Dto\Scope;
use F1monkey\EveEsiBundle\Exception\ApiClient\ApiClientExceptionInterface;
use F1monkey\EveEsiBundle\Exception\ApiClient\RequestValidationException;
use F1monkey\EveEsiBundle\Exception\Esi\EsiRequestException;
use F1monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1monkey\EveEsiBundle\Exception\OAuth\OAuthRequestException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface AccessTokenServiceInterface
 *
 * @package App\Service\Character
 */
interface AccessTokenServiceInterface
{
    /**
     * @param Collection<int, Scope> $scopes
     *
     * @return string
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     */
    public function getRedirectUrl(Collection $scopes): string;

    /**
     * @param UserInterface $user
     * @param string        $authenticationCode
     *
     * @return CharacterToken
     * @throws RequestValidationException
     * @throws OAuthRequestException
     * @throws EsiRequestException
     * @throws ApiClientExceptionInterface
     */
    public function verifyCode(UserInterface $user, string $authenticationCode): CharacterToken;

    /**
     * @param UserInterface $user
     * @param string        $characterId
     *
     * @return CharacterToken
     * @throws ApiClientExceptionInterface
     * @throws OAuthRequestException
     * @throws RequestValidationException
     * @throws EntityNotFoundException
     */
    public function refreshToken(UserInterface $user, string $characterId): CharacterToken;
}