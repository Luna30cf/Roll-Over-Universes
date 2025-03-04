<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création d'un auteur par défaut
        $author = new Author();
        $author->setName($faker->name);
        $manager->persist($author);

        // Création de quelques catégories
        $categories = [];
        $categoryNames = ['JDR', 'Set de dés'];

        foreach ($categoryNames as $name) {
            $category = new Categories();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Exécution des requêtes en base de données
        $manager->flush();
    }
}
