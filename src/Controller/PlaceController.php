<?php

namespace App\Controller;

use App\Entity\Place;
use App\Repository\PlaceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

#[Route('/place', name: 'app_place.')]
class PlaceController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(Request $request, PlaceRepository $placesrepo, ManagerRegistry $doctrine): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Hinzufügen',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newplace = new Place();
            $newplace->setName($data['name']);
            $em = $doctrine->getManager();
            $em->persist($newplace);
            $em->flush();
            return $this->redirectToRoute('app_place.list');
        }

        $places = $placesrepo->findAll();
        return $this->render('place/index.html.twig', [
            'places' => $places,
            'placeForm' => $form->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function add($id, PlaceRepository $repo, ManagerRegistry $doctrine): Response
    {
        $place = $repo->find($id);
        $em = $doctrine->getManager();
        $em->remove($place);
        $em->flush();
        return $this->redirectToRoute('app_place.list');
    }
}
