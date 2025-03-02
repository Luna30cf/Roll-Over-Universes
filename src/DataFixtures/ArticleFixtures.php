<?php


namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Categories;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 📌 Création d'une catégorie
        $category = new Categories();
        $category->setName("Meubles");
        $manager->persist($category);
        $manager->flush();

        // 📌 Création d'un auteur
        $author = new Author();
        $author->setName("Admin");
        $manager->persist($author);
        $manager->flush();

        // 📌 Chemin du dossier contenant les images
        $imagePath = __DIR__ . '/../../public/articleImages/';

        // 📌 Articles avec leurs images basées sur leur nom
        $articles = [
            ["name" => "Chaise moderne", "description" => "Belle chaise en bois", "price" => 120, "items_stored" => 5],
            ["name" => "Table en bois", "description" => "Table solide en chêne", "price" => 250, "items_stored" => 3],
            ["name" => "Lampe design", "description" => "Lampe LED moderne", "price" => 80, "items_stored" => 10]
        ];

        foreach ($articles as $data) {
            $article = new Article();
            $article->setName($data["name"]);
            $article->setDescription($data["description"]);
            $article->setPrice($data["price"]);
            $article->setItemsStored($data["items_stored"]);
            $article->setPublicationDate(new DateTime());

            // 📌 Génère le nom de fichier basé sur le nom de l'article
            $imageName = str_replace(' ', '_', strtolower($data["name"])) . ".png"; // Ex: "chaise_moderne.png"

            // 📌 Vérifie si l'image existe dans `public/articleImages/`
            if (file_exists($imagePath . $imageName)) {
                $article->setCover($imageName);
            } else {
                $article->setCover(null); // 📌 Mettre NULL si l'image n'existe pas
            }

            $article->setCategory($category);
            $article->setAuthor($author);

            $manager->persist($article);
        }

        $manager->flush();
    }
}
