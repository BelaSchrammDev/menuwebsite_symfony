<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class PrivacyPolicyController extends AbstractController
{
    #[Route('/privacy', name: 'app_privacy')]
    public function privacypolicy(): Response
    {
        return $this->render('privacy_policy/privacy.html.twig');
    }

    #[Route('/imprint', name: 'app_imprint')]
    public function imprint(): Response
    {
        return $this->render('privacy_policy/imprint.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(MailerInterface $mailer, Request $request): Response
    {
        $contactForm = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Dein Name',
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Anliegen',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Schreib ein paar Zeilen',
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Absenden',
                'attr' => [
                    'class' => 'btn btn-outline-success float-right',
                ],
            ])
            ->getForm();
        
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $data = $contactForm->getData();
            $email = (new Email())
                ->from('menucard@bela-schramm.de')
                ->to('admin@bela-schramm.de')
                ->subject('Kontaktanfrage')
                ->text('Von: ' . $data['name'] . "\n\n" . $data['content']);

            $mailer->send($email);
            $this->addFlash('success', 'Nachricht wurde an den Betreiber gesendet');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('privacy_policy/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
