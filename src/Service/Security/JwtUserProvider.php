<?php
declare(strict_types=1);

namespace App\Service\Security;

use App\Dto\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class JwtUserProvider
 *
 * @package App\Service\Security
 */
class JwtUserProvider implements UserProviderInterface
{
    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        return new User($username);
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return new User($user->getUsername());
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return $class === User::class;
    }
}