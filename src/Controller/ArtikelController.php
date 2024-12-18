<?php

namespace App\Controller;

use App\Entity\Artikel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ArtikelController extends AbstractController
{
    #[Route('/artikel', name: 'app_artikel')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $artikel = new Artikel();
        $artikel->setTitel("Unser erster Artikel");

        $em = $doctrine->getManager();

        // save new artikel
        // $em->persist($artikel);
        // $em->flush();

        $newartikel = $em->getRepository(Artikel::class)->findby(['id' => 1]);
        $em->remove($newartikel[0]);
        $em->flush();

        return $this->render('artikel/index.html.twig', [
            'artikels' => $newartikel,
        ]);
    }
}
