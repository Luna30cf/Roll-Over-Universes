<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment/confirmation', name: 'payment_confirmation')]
    public function confirmPayment(): Response
    {
        return $this->render('cart/confirmation.html.twig');
    }
}
