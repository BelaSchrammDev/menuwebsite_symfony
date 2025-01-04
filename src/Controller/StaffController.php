<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/staff', name: 'app_staff.')]
class StaffController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function index(UserRepository $userrepo): Response
    {
        $users = $userrepo->findAll();
        return $this->render('staff/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete($id, UserRepository $userrepo, ManagerRegistry $doctrine): Response
    {
        $user = $userrepo->find($id);
        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('app_staff.list');
    }

    #[Route('/togglerole/{id},{role}', name: 'toggle_role')]
    public function toggleRole($id, $role, UserRepository $userrepo, ManagerRegistry $doctrine): Response
    {
        $user = $userrepo->find($id);
        $roles = $user->getRoles();
        if (in_array($role, $roles)) {
            $key = array_search($role, $roles);
            unset($roles[$key]);
        } else {
            $roles[] = $role;
        }
        $user->setRoles($roles);
        $em = $doctrine->getManager();
        $em->flush();
        return $this->redirectToRoute('app_staff.list');
    }
}
