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
use F1monkey\EveEsiBundle\Service\Esi\VerifyTokenServiceInterface;
use F1monkey\EveEsiBundle\Service\OAuth\OAuthServiceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AccessTokenService
 *
 * @package App\Service\Character
 */
class AccessTokenService implements AccessTokenServiceInterface
{
    /**
     * @var OAuthServiceInterface
     */
    protected OAuthServiceInterface $oauthService;

    /**
     * @var VerifyTokenServiceInterface
     */
    protected VerifyTokenServiceInterface $verifyTokenService;

    /**
     * @var CharacterTokenManagerInterface
     */
    protected CharacterTokenManagerInterface $characterTokenManager;

    /**
     * AccessTokenService constructor.
     *
     * @param OAuthServiceInterface          $oauthService
     * @param VerifyTokenServiceInterface    $verifyTokenService
     * @param CharacterTokenManagerInterface $characterTokenManager
     */
    public function __construct(
        OAuthServiceInterface $oauthService,
        VerifyTokenServiceInterface $verifyTokenService,
        CharacterTokenManagerInterface $characterTokenManager
    )
    {
        $this->oauthService          = $oauthService;
        $this->verifyTokenService    = $verifyTokenService;
        $this->characterTokenManager = $characterTokenManager;
    }

    /**
     * @param OAuthServiceInterface $oauthService
     */
    public function setOauthService(OAuthServiceInterface $oauthService): void
    {
        $this->oauthService = $oauthService;
    }

    /**
     * @param VerifyTokenServiceInterface $verifyTokenService
     */
    public function setVerifyTokenService(VerifyTokenServiceInterface $verifyTokenService): void
    {
        $this->verifyTokenService = $verifyTokenService;
    }

    /**
     * @param Collection<int, Scope> $scopes
     *
     * @return string
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     * @throws OAuthRequestException
     */
    public function getRedirectUrl(Collection $scopes): string
    {
        return $this->oauthService->createRedirectUrl($scopes);
    }

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
    public function verifyCode(UserInterface $user, string $authenticationCode): CharacterToken
    {
        $tokens        = $this->oauthService->verifyCode($authenticationCode);
        $characterData = $this->verifyTokenService->verifyAccessToken($tokens->getAccessToken());

        return $this->characterTokenManager->createFromEsiData($user, $tokens, $characterData);
    }

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
    public function refreshToken(UserInterface $user, string $characterId): CharacterToken
    {
        $characterToken = $this->characterTokenManager->getByUserAndCharacter($user, $characterId);

        $tokens = $this->oauthService->refreshToken($characterId);
        $characterToken->setAccessToken($tokens->getAccessToken());
        $this->characterTokenManager->save($characterToken);

        return $characterToken;
    }
}