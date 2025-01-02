<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/order', name: 'app_order.')]

class OrderController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/create/{id}', name: 'create')]
    public function createOrder(Gericht $gericht): Response
    {
        $order = new Order();
        $order->setPlace('Tisch 1');
        $order->setOrdernumber($gericht->getId());
        $order->setName($gericht->getName());
        $order->setPrice($gericht->getPreis());

        return $this->render('order/create.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
