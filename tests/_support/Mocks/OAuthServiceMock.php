<?php
declare(strict_types=1);

namespace App\Tests\_support\Mocks;

use Doctrine\Common\Collections\Collection;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use F1monkey\EveEsiBundle\Dto\Scope;
use F1monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1monkey\EveEsiBundle\Service\OAuth\OAuthServiceInterface;

/**
 * Class OAuthServiceMock
 *
 * @package App\Tests\_support\Mocks
 */
class OAuthServiceMock implements OAuthServiceInterface
{
    public const INVALID_SCOPE = 'invalid-scope';

    /**
     * Generate URL to redirect user for authentication
     *
     * @param Collection<int, Scope> $scopes
     *
     * @return string
     * @throws InvalidScopeCodeException
     * @throws EmptyScopeCollectionException
     */
    public function createRedirectUrl(Collection $scopes): string
    {
        if ($scopes->isEmpty()) {
            throw new EmptyScopeCollectionException($scopes);
        }
        /** @var Scope $first */
        $first = $scopes->first();
        if ($first->getCode() === static::INVALID_SCOPE) {
            throw new InvalidScopeCodeException($scopes);
        }

        return 'url';
    }

    /**
     * Get access and refresh tokens by authenticated user's authorization code
     *
     * @param string $authorizationCode
     *
     * @return TokenResponse
     */
    public function verifyCode(string $authorizationCode): TokenResponse
    {
        return (new TokenResponse())->setTokenType('tokenType')
                                    ->setExpiresIn(1200)
                                    ->setAccessToken('accessToken_' . uniqid())
                                    ->setRefreshToken('refreshToken_' . uniqid());
    }

    /**
     * Get new access token from EVE SSO
     *
     * @param string $refreshToken
     *
     * @return TokenResponse
     */
    public function refreshToken(string $refreshToken): TokenResponse
    {
        return (new TokenResponse())->setTokenType('tokenType')
                                    ->setExpiresIn(1200)
                                    ->setAccessToken('accessToken_' . uniqid())
                                    ->setRefreshToken('refreshToken_' . uniqid());
    }
}