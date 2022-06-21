<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word())
                     ->setCreatedAt($faker->dateTime())
                     ->setUpdatedAt($faker->dateTime());

            $manager->persist($category);

            for ($j = 0; $j < mt_rand(3, 25); $j++) {
                $article = new Article();
                $article->setTitle($faker->sentence(mt_rand(3, 4)))
                        ->setImage($faker->imageUrl(480, 480, $category->getName(), false))
                        ->setDescription($faker->paragraph(mt_rand(2, 4)))
                        ->setContent($faker->text(mt_rand(2000, 6000)))
                        ->setAuthor($faker->name)
                        ->setCreatedAt($faker->dateTime())
                        ->setUpdatedAt($faker->dateTime())
                        ->setIsPublished($faker->randomElement([true, false]))
                        ->addCategory($category);
                $manager->persist($article);
            }
        }

        $manager->flush();
    }
}
