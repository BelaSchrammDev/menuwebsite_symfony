<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtType;
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
        $form = $this->createForm(GerichtType::class, $newgericht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $da = $doctrine->getManager();

            $picture = $request->files->get('gericht')['picture'];
            if ($picture) {
                $pictureName = md5(uniqid()) . '.' . $picture->guessExtension();
                $picture->move($this->getParameter('recipes_directory'), $pictureName);
                $newgericht->setPicture($pictureName);
            }

            $da->persist($newgericht);
            $da->flush();
            $this->addFlash('success', 'Gericht ' . $newgericht->getName() . ' wurde angelegt');
            return $this->redirectToRoute('app_gericht.list');
        }

        return $this->render('gericht/create.html.twig', [
            'gerichtForm' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit($id, ManagerRegistry $doctrine, Request $request): Response
    {
        $da = $doctrine->getManager();
        $gr = $da->getRepository(Gericht::class);
        $gericht = $gr->find($id);

        $form = $this->createForm(GerichtType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $da = $doctrine->getManager();
            $da->persist($gericht);
            $da->flush();
            $this->addFlash('success', 'Gericht ' . $gericht->getName() . ' wurde geändert');
            return $this->redirectToRoute('app_gericht.list');
        }

        return $this->render('gericht/create.html.twig', [
            'gerichtForm' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        if (!$id) return $this->redirectToRoute('app_gericht.list');

        $da = $doctrine->getManager();
        $gr = $da->getRepository(Gericht::class);
        $gericht = $gr->find($id);

        if (!$gericht) {
            $this->addFlash('error', 'Gericht nicht gefunden');
            return $this->redirectToRoute('app_gericht.list');
        }

        $da->remove($gericht);
        $da->flush();

        $this->addFlash('success', 'Gericht ' . $gericht->getName() . ' wurde gelöscht');

        return $this->redirectToRoute('app_gericht.list');
    }
}
