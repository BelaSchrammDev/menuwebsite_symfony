<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Repository\GerichtRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gericht', name: 'app_gericht.')]

class GerichtController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(GerichtRepository $gerichtrepo): Response
    {
        $gerichte = $gerichtrepo->findAll();
        return $this->render('gericht/index.html.twig', [
            'gerichte' => $gerichte,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $newgericht = new Gericht();
        $newgericht->setName('Wiener Schnitzel');

        $da = $doctrine->getManager();
        $da->persist($newgericht);
        $da->flush();

        return new Response('Gericht wurde erstellt');
    }
}
