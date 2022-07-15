<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USERNAME = 'johndoe';
    public const PASSWORD = 'test';
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        /** @var PasswordHasherFactoryInterface $hasher */
        $user = new User();

        $user->setUsername(self::USERNAME);
        $password = $this->hasher->hashPassword($user, self::PASSWORD);
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }
}
