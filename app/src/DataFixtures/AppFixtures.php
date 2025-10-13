<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admins = [
            ['email' => 'admin1@pennarbed.test', 'password' => 'Admin#123'],
            ['email' => 'admin2@pennarbed.test', 'password' => 'Admin#123'],
            ['email' => 'admin3@pennarbed.test', 'password' => 'Admin#123'],
        ];

        foreach ($admins as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $hashed = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPasswordHash($hashed);
            $manager->persist($user);
        }

        $manager->flush();
    }
}


