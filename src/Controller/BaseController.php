<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    protected function getCategories(): array
    {
        return $this->articleRepository->findAll();
    }

    protected function renderWithNavbar(string $view, array $parameters = []): Response
    {
        $parameters['articles'] = $this->getCategories();

        return $this->render($view, $parameters);
    }
}
