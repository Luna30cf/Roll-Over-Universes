<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account')]
    public function account(): Response
    {
        return $this->render('account/account.html.twig');
    }

    #[Route('/account/edit', name: 'account_edit')]
    public function edit(): Response
    {
        return $this->render('account/edit.html.twig');
    }
}
