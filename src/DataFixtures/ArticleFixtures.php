<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categories;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Filesystem\Filesystem;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $filesystem = new Filesystem();

        // Création d'un auteur par défaut
        $author = new Author();
        $author->setName($faker->name);
        $manager->persist($author);

        // Création de quelques catégories
        $categories = [];
        $categoryNames = ['Meubles', 'Décoration', 'Électronique', 'Jouets', 'Livres'];

        foreach ($categoryNames as $name) {
            $category = new Categories();
            $category->setName($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Création de produits fictifs
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $productName = ucfirst($faker->words(2, true)); // Générer un nom
            $article->setName($productName);
            $article->setDescription($faker->sentence(10));
            $article->setPrice($faker->randomFloat(2, 10, 500));
            $article->setItemsStored($faker->numberBetween(1, 100));
            $article->setPublicationDate($faker->dateTimeThisYear());
            $article->setAuthor($author);
            $article->setCategory($faker->randomElement($categories));

            // Générer le nom du fichier image
            $imageName = strtolower(str_replace([' ', "'", '"', ',', ';'], '_', $productName)) . '.png';
            $imagePath = __DIR__ . '/../../public/assets/articleImages/' . $imageName;

            // Vérifier si l'image existe
            if ($filesystem->exists($imagePath)) {
                $article->setCover($imageName);
            } else {
                $article->setCover('default.png'); // Image par défaut si non trouvée
            }

            $manager->persist($article);
        }

        $manager->flush();
    }
}
