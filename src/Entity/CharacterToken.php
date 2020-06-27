<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\CharacterTokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CharacterToken
 *
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass=CharacterTokenRepository::class)
 */
class CharacterToken
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    private string $accessToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1024, nullable=false)
     */
    private string $refreshToken;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $ownerHash;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity=Character::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private Character $character;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return CharacterToken
     */
    public function setUsername(string $username): CharacterToken
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     *
     * @return CharacterToken
     */
    public function setAccessToken(string $accessToken): CharacterToken
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     *
     * @return CharacterToken
     */
    public function setRefreshToken(string $refreshToken): CharacterToken
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwnerHash(): string
    {
        return $this->ownerHash;
    }

    /**
     * @param string $ownerHash
     *
     * @return CharacterToken
     */
    public function setOwnerHash(string $ownerHash): CharacterToken
    {
        $this->ownerHash = $ownerHash;

        return $this;
    }

    /**
     * @return Character
     */
    public function getCharacter(): Character
    {
        return $this->character;
    }

    /**
     * @param Character $character
     *
     * @return CharacterToken
     */
    public function setCharacter(Character $character): CharacterToken
    {
        $this->character = $character;

        return $this;
    }
}
