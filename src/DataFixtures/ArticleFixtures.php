<?php

namespace App\DataFixtures;

use Exception;
use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Retrieve all categories
        $categories = $manager->getRepository(Category::class)->findAll();

        if (empty($categories)) {
            throw new Exception('No categories found, please run the Category Fixtures first.');
        }

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setName($faker->sentence);
            $article->setSlug($faker->slug);
            $article->setPostBody($faker->paragraph);
            $article->setStatus($faker->boolean);
            $article->setThumbnail($faker->imageUrl);
            $article->setCreatedAt(new DateTimeImmutable());
            $article->setUpdatedAt(new DateTimeImmutable());

            // Assign a random category to the article
            $category = $categories[array_rand($categories)];
            $article->setCategory($category);

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
