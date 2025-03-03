<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartArticle;
use App\Entity\Article;
use App\Repository\CartRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartRepository $cartRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $cartRepository->findOneBy(['user' => $user]);

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function addToCart(int $id, ArticleRepository $articleRepository, CartRepository $cartRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $cartRepository->findOneBy(['user' => $user]);
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
        }

        $article = $articleRepository->find($id);
        if (!$article) {
            return $this->redirectToRoute('article_list');
        }

        $cartArticle = new CartArticle();
        $cartArticle->setCart($cart);
        $cartArticle->setArticle($article);
        $entityManager->persist($cartArticle);
        $entityManager->flush();

        return $this->redirectToRoute('cart_index');
    }
}
