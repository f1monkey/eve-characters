<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Character
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 */
class Character
{
    /**
     * @var string|null
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $eveCharacterId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $eveCharacterName;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getEveCharacterId(): int
    {
        return $this->eveCharacterId;
    }

    /**
     * @param int $eveCharacterId
     *
     * @return Character
     */
    public function setEveCharacterId(int $eveCharacterId): Character
    {
        $this->eveCharacterId = $eveCharacterId;

        return $this;
    }

    /**
     * @return string
     */
    public function getEveCharacterName(): string
    {
        return $this->eveCharacterName;
    }

    /**
     * @param string $eveCharacterName
     *
     * @return Character
     */
    public function setEveCharacterName(string $eveCharacterName): Character
    {
        $this->eveCharacterName = $eveCharacterName;

        return $this;
    }
}
