<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViewController extends AbstractController
{
    #[Route('/view', name: 'app_view')]
    public function index(): Response
    {
        $day = date('l');

        $user = [
            'name' => 'John Doe',
            'email' => 'belaschramm@aol.de',
            'age' => 30,
            'lastname' => 'Doe',
            'firstname' => 'John',
        ];

        $fruits = ['apple', 'banana', 'cherry', 'date', 'elderberry'];

        return $this->render('view/index.html.twig', [
            'weekday' => $day,
            'user' => $user,
            'fruits' => $fruits,
        ]);
    }
}
