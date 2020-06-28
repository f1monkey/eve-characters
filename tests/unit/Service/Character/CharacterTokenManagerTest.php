<?php
declare(strict_types=1);

namespace App\Tests\unit\Service\Character;

use App\Entity\CharacterToken;
use App\Exception\Entity\EntityNotFoundException;
use App\Factory\Character\CharacterTokenFactoryInterface;
use App\Repository\CharacterTokenRepository;
use App\Service\Character\CharacterTokenManager;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use F1monkey\EveEsiBundle\Dto\Esi\Response\VerifyAccessTokenResponse;
use F1monkey\EveEsiBundle\Dto\OAuth\Response\TokenResponse;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CharacterTokenManagerTest
 *
 * @package App\Tests\unit\Service\Character
 */
class CharacterTokenManagerTest extends Unit
{
    /**
     * @throws NonUniqueResultException
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateTokenFromEsiData()
    {
        $expected = $this->makeEmpty(CharacterToken::class);

        /** @var CharacterTokenManager $manager */
        $manager = $this->constructEmptyExcept(
            CharacterTokenManager::class,
            'createFromEsiData',
            [
                $this->makeEmpty(
                    CharacterTokenFactoryInterface::class,
                    [
                        'createFromEsiData' => $expected,
                    ]
                ),
                $this->makeEmpty(CharacterTokenRepository::class),
                $this->makeEmpty(EntityManagerInterface::class),
            ],
            [
                'getByUserAndEveCharacterId' => function () {
                    throw new EntityNotFoundException();
                },
            ]
        );
        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class);

        /** @var TokenResponse $tokenResponse */
        $tokenResponse = $this->makeEmpty(TokenResponse::class);
        /** @var VerifyAccessTokenResponse $accessTokenRespone */
        $accessTokenRespone = $this->makeEmpty(VerifyAccessTokenResponse::class);
        $result             = $manager->createFromEsiData($user, $tokenResponse, $accessTokenRespone);

        $this->assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function testCanUpdateTokenFromEsiData()
    {
        $expected = $this->makeEmpty(CharacterToken::class);

        /** @var CharacterTokenManager $manager */
        $manager = $this->constructEmptyExcept(
            CharacterTokenManager::class,
            'createFromEsiData',
            [
                $this->makeEmpty(
                    CharacterTokenFactoryInterface::class,
                    [
                        'fillFromEsiData' => Expected::once($expected),
                    ]
                ),
                $this->makeEmpty(CharacterTokenRepository::class),
                $this->makeEmpty(EntityManagerInterface::class),
            ],
            [
                'getByUserAndEveCharacterId' => $expected,
            ]
        );
        /** @var UserInterface $user */
        $user = $this->makeEmpty(UserInterface::class);

        /** @var TokenResponse $tokenResponse */
        $tokenResponse = $this->makeEmpty(TokenResponse::class);
        /** @var VerifyAccessTokenResponse $accessTokenRespone */
        $accessTokenRespone = $this->makeEmpty(VerifyAccessTokenResponse::class);
        $result             = $manager->createFromEsiData($user, $tokenResponse, $accessTokenRespone);

        static::assertSame($expected, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanGetTokensByUser()
    {
        /** @var UserInterface $user */
        $user = $this->makeEmpty(
            UserInterface::class,
            [
                'getUsername' => 'user',
            ]
        );

        $expected = [$this->makeEmpty(CharacterToken::class)];

        /** @var CharacterTokenFactoryInterface $factory */
        $factory = $this->makeEmpty(CharacterTokenFactoryInterface::class);
        /** @var CharacterTokenRepository $repository */
        $repository = $this->makeEmpty(
            CharacterTokenRepository::class,
            [
                'findByUsername' => $expected,
            ]
        );
        /** @var EntityManagerInterface $em */
        $em = $this->makeEmpty(EntityManagerInterface::class);

        $manager = new CharacterTokenManager($factory, $repository, $em);
        $result  = $manager->getByUser($user);

        static::assertSame($expected, $result->toArray());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanGetTokenByUserAndCharacter()
    {
        /** @var UserInterface $user */
        $user = $this->makeEmpty(
            UserInterface::class,
            [
                'getUsername' => 'user',
            ]
        );

        $expected = [$this->makeEmpty(CharacterToken::class)];

        /** @var CharacterTokenFactoryInterface $factory */
        $factory = $this->makeEmpty(CharacterTokenFactoryInterface::class);
        /** @var CharacterTokenRepository $repository */
        $repository = $this->makeEmpty(
            CharacterTokenRepository::class,
            [
                'findByUsername' => $expected,
            ]
        );
        /** @var EntityManagerInterface $em */
        $em = $this->makeEmpty(EntityManagerInterface::class);

        $manager = new CharacterTokenManager($factory, $repository, $em);
        $result  = $manager->getByUser($user);

        static::assertSame($expected, $result->toArray());
    }
}