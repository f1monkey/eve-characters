<?php
declare(strict_types=1);

namespace App\Tests\unit\Factory\Character;

use App\Entity\Character;
use App\Entity\CharacterToken;
use App\Factory\Character\CharacterTokenFactory;
use App\Service\Character\CharacterManagerInterface;
use Codeception\Test\Unit;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use F1monkey\EveEsiBundle\Dto\Scope;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterTokenFactoryTest
 *
 * @package App\Tests\unit\Factory\Character
 */
class CharacterTokenFactoryTest extends Unit
{
    /**
     * @dataProvider tokenResponseProvider
     *
     * @param UserInterface             $user
     * @param TokenResponse             $tokenResponse
     * @param VerifyAccessTokenResponse $accessTokenResponse
     * @param Character                 $character
     *
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateCharacterTokenFromEsiData(
        UserInterface $user,
        TokenResponse $tokenResponse,
        VerifyAccessTokenResponse $accessTokenResponse,
        Character $character
    )
    {

        /** @var CharacterManagerInterface $manager */
        $manager = $this->makeEmpty(
            CharacterManagerInterface::class,
            [
                'getOrCreate' => $character,
            ]
        );

        $factory = new CharacterTokenFactory($manager);
        $result  = $factory->createFromEsiData($user, $tokenResponse, $accessTokenResponse);

        static::assertSame($user->getUsername(), $result->getUsername());
        static::assertSame($tokenResponse->getAccessToken(), $result->getAccessToken());
        static::assertSame($tokenResponse->getRefreshToken(), $result->getRefreshToken());
        static::assertSame($accessTokenResponse->getOwnerHash(), $result->getOwnerHash());
        static::assertSame($character, $result->getCharacter());
    }

    /**
     * @dataProvider tokenResponseProvider
     *
     * @param UserInterface             $user
     * @param TokenResponse             $tokenResponse
     * @param VerifyAccessTokenResponse $accessTokenResponse
     * @param Character                 $character
     *
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanFillCharacterTokenFromEsiData(
        UserInterface $user,
        TokenResponse $tokenResponse,
        VerifyAccessTokenResponse $accessTokenResponse,
        Character $character
    )
    {

        /** @var CharacterManagerInterface $manager */
        $manager = $this->makeEmpty(
            CharacterManagerInterface::class,
            [
                'getOrCreate' => $character,
            ]
        );

        $characterToken = new CharacterToken();
        $characterToken->setUsername($user->getUsername());

        $factory = new CharacterTokenFactory($manager);
        $result  = $factory->fillFromEsiData($characterToken, $tokenResponse, $accessTokenResponse);

        static::assertSame($user->getUsername(), $result->getUsername());
        static::assertSame($tokenResponse->getAccessToken(), $result->getAccessToken());
        static::assertSame($tokenResponse->getRefreshToken(), $result->getRefreshToken());
        static::assertSame($accessTokenResponse->getOwnerHash(), $result->getOwnerHash());
        static::assertSame($character, $result->getCharacter());
    }

    /**
     * @return array
     * @throws Exception
     */
    public function tokenResponseProvider(): array
    {
        $user = $this->makeEmpty(
            UserInterface::class,
            [
                'getUsername' => 'user',
            ]
        );

        $tokenResponse = new TokenResponse();
        $tokenResponse->setAccessToken('accessToken')
                      ->setRefreshToken('refreshToken')
                      ->setTokenType('tokenType')
                      ->setExpiresIn(1200);

        $accessTokenResponse = new VerifyAccessTokenResponse();
        $accessTokenResponse->setTokenType('tokenType')
                            ->setOwnerHash('hash')
                            ->setCharacterId(123)
                            ->setCharacterName('name')
                            ->setScopes(new ArrayCollection([new Scope('scope')]))
                            ->setExpiresOn(new DateTimeImmutable());

        $character = new Character();
        $character->setEveCharacterName('name')
                  ->setEveCharacterId(123);

        return [
            [$user, $tokenResponse, $accessTokenResponse, $character],
        ];
    }
}