<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends BaseController
{
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->renderWithNavbar('pages/homepage.html.twig');
    }
}
