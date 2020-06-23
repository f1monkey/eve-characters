<?php
declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 *
 * @package App\Dto
 */
class User implements UserInterface
{
    /**
     * @var string
     */
    protected string $username;

    /**
     * User constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }
}