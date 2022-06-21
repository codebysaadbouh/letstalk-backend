<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * Password Encoder
     * @var UserPasswordHasherInterface
     */
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($u=0; $u < 25; $u++ ) { // 25 users
            $user = new User();
            $hash = $this->encoder->hashPassword($user, 'password');
            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($hash);
            $manager->persist($user);

            for ($i = 0; $i < 10; $i++) { // Categories
                $category = new Category();
                $category->setName($faker->word())
                    ->setCreatedAt($faker->dateTime())
                    ->setUpdatedAt($faker->dateTime());

                $manager->persist($category);

                for ($j = 0; $j < mt_rand(3, 25); $j++) { // 3 to 25 articles per category pour chaque user
                    $article = new Article();
                    $article->setTitle($faker->sentence(mt_rand(3, 4)))
                        ->setImage($faker->imageUrl(480, 480, $category->getName(), false))
                        ->setDescription($faker->paragraph(mt_rand(2, 4)))
                        ->setContent($faker->text(mt_rand(2000, 6000)))
                        ->setCreatedAt($faker->dateTime())
                        ->setUpdatedAt($faker->dateTime())
                        ->setIsPublished($faker->randomElement([true, false]))
                        ->addCategory($category)
                        ->setUsercreator($user);
                    $manager->persist($article);
                }
            }
        }
        $manager->flush();
    }
}
