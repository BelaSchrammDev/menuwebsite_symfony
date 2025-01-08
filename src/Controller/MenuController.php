<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use App\Repository\KategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/menu/{katid}', name: 'app_menu', defaults: ['katid' => 0])]
    public function index($katid, GerichtRepository $gerichtrepo, KategorieRepository $kategorieRepository): Response
    {
        $kategories = $kategorieRepository->findAll();
        $withAllLink = false;
        if ($katid == 0) {
            $gerichte = $gerichtrepo->findAll();
        } else {
            $kategorie = $kategorieRepository->find($katid);
            $kategories = [$kategorie];
            $withAllLink = true;
            $gerichte = $gerichtrepo->findAllByKategorieID($kategorie);
        }

        return $this->render('menu/index.html.twig', [
            'gerichte' => $gerichte,
            'kategories' => $kategories,
            'withAllLink' => $withAllLink,
        ]);
    }
}
