<?php
declare(strict_types=1);

namespace App\Tests\unit\Factory\Character;

use App\Factory\Character\CharacterFactory;
use Codeception\Test\Unit;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Class CharacterFactoryTest
 *
 * @package App\Tests\unit\Factory\Character
 */
class CharacterFactoryTest extends Unit
{
    /**
     * @throws ExpectationFailedException
     */
    public function testCanCreateCharacter()
    {
        $id   = 123;
        $name = 'name';

        $factory = new CharacterFactory();
        $result  = $factory->create($id, $name);

        static::assertSame($id, $result->getEveCharacterId());
        static::assertSame($name, $result->getEveCharacterName());
    }
}