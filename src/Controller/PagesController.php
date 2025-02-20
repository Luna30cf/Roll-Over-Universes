<?php

namespace App\Controller;

use App\Form\RegistrationType;  // Importation correcte du formulaire
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PagesController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('HomePage/index.html.twig');
    }

    #[Route('/signin', name: 'signin')]
    public function signin(Request $request): Response
    {
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Redirection après soumission réussie
            return $this->redirectToRoute('homepage');
        }

        return $this->render('signin/signin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
