<?php

namespace App\DataFixtures;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $now = new DateTimeImmutable(); 

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName(ucfirst($faker->word));
            $category->setSlug($faker->slug);
            $category->setStatus($faker->boolean);
            $category->setCreatedAt($now);
            $category->setUpdatedAt(new DateTimeImmutable());

            $manager->persist($category);
        }
        $manager->flush();
    }
}
