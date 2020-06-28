<?php
declare(strict_types=1);

namespace App\Tests\unit\Service\Character;

use App\Entity\CharacterToken;
use App\Service\Character\AccessTokenService;
use App\Service\Character\CharacterTokenManagerInterface;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use F1monkey\EveEsiBundle\Exception\ApiClient\ApiClientExceptionInterface;
use F1monkey\EveEsiBundle\Exception\ApiClient\RequestValidationException;
use F1monkey\EveEsiBundle\Exception\Esi\EsiRequestException;
use F1monkey\EveEsiBundle\Exception\OAuth\EmptyScopeCollectionException;
use F1monkey\EveEsiBundle\Exception\OAuth\InvalidScopeCodeException;
use F1monkey\EveEsiBundle\Exception\OAuth\OAuthRequestException;
use F1monkey\EveEsiBundle\Service\Esi\VerifyTokenServiceInterface;
use F1monkey\EveEsiBundle\Service\OAuth\OAuthServiceInterface;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AccessTokenServiceTest
 *
 * @package App\Tests\unit\Service\Character
 */
class AccessTokenServiceTest extends Unit
{
    /**
     * @throws EmptyScopeCollectionException
     * @throws InvalidScopeCodeException
     * @throws ExpectationFailedException
     * @throws OAuthRequestException
     * @throws Exception
     */
    public function testCanGetRedirectUrl()
    {
        $expected = 'url';

        /** @var OAuthServiceInterface $oauthService */
        $oauthService = $this->makeEmpty(
            OAuthServiceInterface::class,
            [
                'createRedirectUrl' => $expected,
            ]
        );
        /** @var VerifyTokenServiceInterface $verifyTokenService */
        $verifyTokenService = $this->makeEmpty(VerifyTokenServiceInterface::class);
        /** @var CharacterTokenManagerInterface $manager */
        $manager = $this->makeEmpty(CharacterTokenManagerInterface::class);

        $service = new AccessTokenService($oauthService, $verifyTokenService, $manager);
        $result  = $service->getRedirectUrl(new ArrayCollection());

        static::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws OAuthRequestException
     * @throws ApiClientExceptionInterface
     * @throws RequestValidationException
     * @throws EsiRequestException
     * @throws Exception
     */
    public function testCanVerifyCode()
    {
        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class);
        /** @var OAuthServiceInterface $oauthService */
        $oauthService = $this->makeEmpty(
            OAuthServiceInterface::class,
            ['verifyCode' => Expected::once(new TokenResponse())]
        );
        /** @var VerifyTokenServiceInterface $verifyTokenService */
        $verifyTokenService = $this->makeEmpty(VerifyTokenServiceInterface::class, [
            'verifyAccessToken' => Expected::once(new VerifyAccessTokenResponse())
        ]);
        $expected = new CharacterToken();
        /** @var CharacterTokenManagerInterface $manager */
        $manager = $this->makeEmpty(CharacterTokenManagerInterface::class, [
            'createFromEsiData' => $expected
        ]);

        $service = new AccessTokenService($oauthService, $verifyTokenService, $manager);
        $result  = $service->verifyCode($user, 'code');

        static::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws OAuthRequestException
     * @throws ApiClientExceptionInterface
     * @throws RequestValidationException
     * @throws Exception
     */
    public function testCanRefreshAccessToken()
    {
        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class);
        /** @var OAuthServiceInterface $oauthService */
        $oauthService = $this->makeEmpty(
            OAuthServiceInterface::class,
            ['refreshToken' => Expected::once(new TokenResponse())]
        );
        /** @var VerifyTokenServiceInterface $verifyTokenService */
        $verifyTokenService = $this->makeEmpty(VerifyTokenServiceInterface::class);
        $expected = new CharacterToken();
        /** @var CharacterTokenManagerInterface $manager */
        $manager = $this->makeEmpty(CharacterTokenManagerInterface::class, [
            'getByUserAndCharacter' => $expected,
            'save' => Expected::once()
        ]);

        $service = new AccessTokenService($oauthService, $verifyTokenService, $manager);
        $result  = $service->refreshToken($user, 'uuid');

        static::assertSame($expected, $result);
    }
}