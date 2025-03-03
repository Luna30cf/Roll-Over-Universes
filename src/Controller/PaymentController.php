<?php

// src/Controller/PaymentController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/checkout', name: 'payment_page')]
    public function checkout(): Response
    {
        return $this->render('payment/paiement.html.twig');
    }

    #[Route('/payment_process', name: 'payment_process', methods: ['POST'])]
    public function processPayment(): Response
    {
        return $this->redirectToRoute('homepage');
    }
}
