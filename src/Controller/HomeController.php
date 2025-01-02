<?php

namespace App\Controller;

use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(GerichtRepository $gr): Response
    {
        $gerichte = $gr->findAll();
        $randomGerichtid = array_rand($gerichte,4);
        $randomGerichte = [];
        foreach ($randomGerichtid as $id) {
            $randomGerichte[] = $gerichte[$id];
        }

        return $this->render('home/index.html.twig', [
            'randomgerichte' => $randomGerichte,
        ]);
    }
}
