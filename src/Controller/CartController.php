<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);

        $products = [];

        foreach($cart as $cartLine) {
            $product = $productRepository->find($cartLine['id']);
            if($product) array_push($products, $product);
        }

        return $this->render('cart/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/addcart/{id}", name="add_cart")
     */
    public function addCart(SessionInterface $session, int $id): Response
    {
        $session->set('cart', []);
        $cart = $session->get('cart', []);
        array_push($cart, array('id' => $id));
        $session->set('cart', $cart);

        return $this->redirectToRoute("home", [], Response::HTTP_SEE_OTHER);
    }
}
