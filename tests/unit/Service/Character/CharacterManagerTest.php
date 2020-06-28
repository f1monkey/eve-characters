<?php
declare(strict_types=1);

namespace App\Tests\unit\Service\Character;

use App\Entity\Character;
use App\Exception\Entity\EntityNotFoundException;
use App\Factory\Character\CharacterFactoryInterface;
use App\Repository\CharacterRepository;
use App\Service\Character\CharacterManager;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class CharacterManagerTest
 *
 * @package App\Tests\unit\Service\Character
 */
class CharacterManagerTest extends Unit
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateCharacter()
    {
        $character = $this->makeEmpty(Character::class);
        /** @var CharacterFactoryInterface $factory */
        $factory = $this->makeEmpty(
            CharacterFactoryInterface::class,
            [
                'create' => Expected::once($character),
            ]
        );
        /** @var EntityManagerInterface $em */
        $em = $this->makeEmpty(EntityManagerInterface::class);
        /** @var CharacterRepository $repository */
        $repository = $this->makeEmpty(CharacterRepository::class);

        $manager = new CharacterManager($factory, $repository, $em);
        $result  = $manager->create(123, 'name');
        static::assertSame($character, $result);
    }

    /**
     * @throws Exception
     */
    public function testCanSaveCharacter()
    {
        /** @var Character $character */
        $character = $this->makeEmpty(Character::class);
        /** @var CharacterFactoryInterface $factory */
        $factory = $this->makeEmpty(CharacterFactoryInterface::class);
        /** @var EntityManagerInterface $em */
        $em = $this->makeEmpty(
            EntityManagerInterface::class,
            [
                'persist' => Expected::once(),
                'flush'   => Expected::once(),
            ]
        );
        /** @var CharacterRepository $repository */
        $repository = $this->makeEmpty(CharacterRepository::class);

        $manager = new CharacterManager($factory, $repository, $em);
        $manager->save($character);
    }

    /**
     * @throws EntityNotFoundException
     * @throws ExpectationFailedException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function testCanGetCharacterByEveCharacterId()
    {
        /** @var Character $character */
        $character = $this->makeEmpty(Character::class);
        /** @var CharacterFactoryInterface $factory */
        $factory = $this->makeEmpty(CharacterFactoryInterface::class);
        /** @var EntityManagerInterface $em */
        $em = $this->makeEmpty(EntityManagerInterface::class);
        /** @var CharacterRepository $repository */
        $repository = $this->makeEmpty(
            CharacterRepository::class,
            [
                'findOneByEveCharacterId' => $character,
            ]
        );

        $manager = new CharacterManager($factory, $repository, $em);
        $result  = $manager->getByEveCharacterId(123);

        static::assertSame($character, $result);
    }

    /**
     * @throws EntityNotFoundException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function testCannotGetNotExistingCharacterByEveCharacterId()
    {
        /** @var CharacterFactoryInterface $factory */
        $factory = $this->makeEmpty(CharacterFactoryInterface::class);
        /** @var EntityManagerInterface $em */
        $em = $this->makeEmpty(EntityManagerInterface::class);
        /** @var CharacterRepository $repository */
        $repository = $this->makeEmpty(
            CharacterRepository::class,
            [
                'findOneByEveCharacterId' => null,
            ]
        );

        $manager = new CharacterManager($factory, $repository, $em);

        $this->expectException(EntityNotFoundException::class);
        $manager->getByEveCharacterId(123);
    }

    /**
     * @throws ExpectationFailedException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function testCanGetOrCreateExistingCharacter()
    {
        /** @var Character $character */
        $character = $this->makeEmpty(Character::class);

        /** @var CharacterManager $manager */
        $manager = $this->makeEmptyExcept(
            CharacterManager::class,
            'getOrCreate',
            [
                'getByEveCharacterId' => Expected::once($character),
                'create'              => Expected::never(),
            ]
        );
        $result  = $manager->getOrCreate(123, '123');

        static::assertSame($character, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws NonUniqueResultException
     * @throws Exception
     */
    public function testCanGetOrCreateNonExistingCharacter()
    {
        /** @var Character $character */
        $character = $this->makeEmpty(Character::class);

        /** @var CharacterManager $manager */
        $manager = $this->makeEmptyExcept(
            CharacterManager::class,
            'getOrCreate',
            [
                'getByEveCharacterId' => Expected::once(
                    function () {
                        throw new EntityNotFoundException();
                    }
                ),
                'create'              => Expected::once($character),
            ]
        );
        $result  = $manager->getOrCreate(123, '123');

        static::assertSame($character, $result);
    }
}