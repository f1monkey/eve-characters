<?php
declare(strict_types=1);

namespace App\Tests\unit\Factory\Api\V1;

use App\Entity\Character;
use App\Factory\Api\V1\CharacterResponseFactory;
use Codeception\Test\Unit;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class CharacterResponseFactoryTest
 *
 * @package App\Tests\unit\Factory\Api\V1
 */
class CharacterResponseFactoryTest extends Unit
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateCharacterResponse()
    {
        $id             = '123';
        $name           = 'character';
        $eveCharacterId = 321;

        /** @var Character $character */
        $character = $this->makeEmpty(
            Character::class,
            [
                'getId'               => $id,
                'getEveCharacterName' => $name,
                'getEveCharacterId'   => $eveCharacterId,
            ]
        );

        $factory = new CharacterResponseFactory();
        $result  = $factory->createCharacterResponse($character);

        static::assertSame($id, $result->getId());
        static::assertSame($name, $result->getCharacterName());
        static::assertSame($eveCharacterId, $result->getCharacterId());
    }
}