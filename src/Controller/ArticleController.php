<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'article_list')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll(); // Récupérer les articles

        return $this->render('article/index.html.twig', [
            'articles' => $articles, // On envoie "articles" au template
        ]);
    }
}
