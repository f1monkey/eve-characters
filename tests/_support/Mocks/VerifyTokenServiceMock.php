<?php
declare(strict_types=1);

namespace App\Tests\_support\Mocks;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\Scope;
use F1monkey\EveEsiBundle\Service\Esi\VerifyTokenServiceInterface;

/**
 * Class VerifyTokenServiceMock
 *
 * @package App\Tests\_support\Mocks
 */
class VerifyTokenServiceMock implements VerifyTokenServiceInterface
{
    /**
     * @var VerifyAccessTokenResponse|null
     */
    protected ?VerifyAccessTokenResponse $response = null;

    /**
     * @param string $accessToken
     *
     * @return VerifyAccessTokenResponse
     */
    public function verifyAccessToken(string $accessToken): VerifyAccessTokenResponse
    {
        return $this->response ?? $this->generateResponse();
    }

    /**
     * @param VerifyAccessTokenResponse|null $response
     *
     * @return VerifyTokenServiceMock
     */
    public function setResponse(?VerifyAccessTokenResponse $response): VerifyTokenServiceMock
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return VerifyAccessTokenResponse
     */
    public function generateResponse(): VerifyAccessTokenResponse
    {
        return (new VerifyAccessTokenResponse())->setCharacterName('character' . uniqid())
                                                ->setCharacterId(rand(100000, 900000))
                                                ->setTokenType('tokenType')
                                                ->setExpiresOn(new DateTimeImmutable('+15 minutes'))
                                                ->setScopes(
                                                    new ArrayCollection([new Scope('publicData')])
                                                )
                                                ->setOwnerHash('ownerHash');
    }
}