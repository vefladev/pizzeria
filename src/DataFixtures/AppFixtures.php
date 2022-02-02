<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Bluemmb;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new Bluemmb\Faker\PicsumPhotosProvider($faker));

        $categories = [];

        for ($i = 0; $i < 5; $i++) {

            $category = new Category();
            $category->setName($faker->region);
            $category->setDescription($faker->text);
            $manager->persist($category);
            array_push($categories, $category);
        }

        for ($i = 0; $i < 3; $i++) {

            $user = new Customer();

            $hashedPassword = $this->hasher->hashPassword(
                $user,
                "admin"
            );

            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setAddress($faker->address);
            $user->setEmail($faker->email);
            $user->setPhoneNumber($faker->mobileNumber);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }

        for ($i = 0; $i < 100; $i++) {

            $product = new Product();
            $product->setDescription($faker->text);
            $product->setName($faker->departmentName);
            $product->setPrice($faker->randomFloat(2, 8, 20));
            $product->setImage($faker->imageUrl(500, 500, true));
            $product->setCategory($categories[rand(0, 4)]);

            $manager->persist($product);
        }
        $manager->flush();
    }
}
