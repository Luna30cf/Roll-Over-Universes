<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categories;
use App\Entity\Author;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product/new', name: 'product_new')]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Assigner une date de publication si elle est vide
            if (!$article->getPublicationDate()) {
                $article->setPublicationDate(new \DateTime());
            }

            // Assigner un auteur par défaut si aucun n'est défini
            $author = $entityManager->getRepository(Author::class)->findOneBy([]);
            if (!$author) {
                $author = new Author();
                $author->setName('Auteur par défaut');
                $entityManager->persist($author);
            }
            $article->setAuthor($author);

            // Gestion de l'image
            $imageFile = $form->get('cover')->getData();
            if ($imageFile) {
                $imageName = strtolower(str_replace(' ', '_', $article->getName())) . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('article_images_directory'), $imageName);
                $article->setCover($imageName);
            } else {
                $article->setCover('default.png');
            }

            // Sauvegarde en base de données
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Produit ajouté avec succès !');

            return $this->redirectToRoute('article_list');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
