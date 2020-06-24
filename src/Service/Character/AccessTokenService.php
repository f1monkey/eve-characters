<?php
declare(strict_types=1);

namespace App\Service\Character;

use Doctrine\Common\Collections\Collection;
use F1Monkey\EveEsiBundle\Dto\Scope;
use F1Monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1Monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1Monkey\EveEsiBundle\Service\OAuth\OAuthServiceInterface;

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
     * CharacterAddService constructor.
     *
     * @param OAuthServiceInterface $oauthService
     */
    public function __construct(OAuthServiceInterface $oauthService)
    {
        $this->oauthService = $oauthService;
    }

    /**
     * @param Collection<int, Scope> $scopes
     *
     * @return string
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     */
    public function getRedirectUrl(Collection $scopes): string
    {
        return $this->oauthService->createRedirectUrl($scopes);
    }
}