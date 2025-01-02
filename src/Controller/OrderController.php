<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\PlaceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/order', name: 'app_order.')]

class OrderController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(OrderRepository $orders, PlaceRepository $placeRepository): Response
    {
        $place = $placeRepository->findOneBy(['name' => 'Tisch 1']);
        $ordersFromPlace = $orders->findBy(['place' => $place->getId(),]);
        return $this->render('order/index.html.twig', [
            'place' => $place->getName(),
            'ordersFromPlace' => $ordersFromPlace,
        ]);
    }

    #[Route('/create/{id}', name: 'create')]
    public function createOrder(Gericht $gericht, ManagerRegistry $doctrine, PlaceRepository $placeRepository): Response
    {
        $order = new Order();
        $place = $placeRepository->findOneBy(['name' => 'Tisch 1']);
        $order->setPlace($place);
        $order->setOrdernumber($gericht->getId());
        $order->setName($gericht->getName());
        $order->setPrice($gericht->getPreis());
        $order->setStatus('offen');

        $em = $doctrine->getManager();
        $em->persist($order);
        $em->flush();

        $this->addFlash('success', $gericht->getName() . ' wurde zur Bestellung hinzugefügt.');

        return $this->redirectToRoute('app_menu');
    }
}
