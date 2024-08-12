<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    private array $roles = [
        'ROLE_USER' => 'user@yopmail.com',
        'ROLE_ADMIN' => 'admin@yopmail.com',
        'ROLE_EDITOR' => 'editor@yopmail.com',
    ];

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        foreach ($this->roles as $role => $email) {
            $user = new User();
            $user->setEmail($email);
            $user->setRoles([$role]);
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $hashedPassword = $this->passwordHasher->hashPassword($user, '12345678');
            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
