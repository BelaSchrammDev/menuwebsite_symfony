<?php

namespace App\Controller;

use App\Service\CurrentPlace;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class MailerController extends AbstractController
{
    #[Route('/mail', name: 'app_mail')]
    public function sendMail(MailerInterface $mailer, Request $request, CurrentPlace $currentPlace): Response
    {
        $emailForm = $this->createFormBuilder()
            ->add('content', TextareaType::class, [
                'label' => 'Nachricht',
                'attr' => [
                    'rows' => 5,
                    'placeholder' => 'Schreib ein paar Zeilen',
                ],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Absenden',
                'attr' => [
                    'class' => 'btn btn-outline-danger float-right',
                ],
            ])
            ->getForm();

        $emailForm->handleRequest($request);

        if ($emailForm->isSubmitted() && $emailForm->isValid()) {
            $data = $emailForm->getData();
            $content = $data['content'];
            $place = $currentPlace->getPlaceName();

            $email = (new TemplatedEmail())
                ->from('admin@bela-schramm.de')
                ->to('bela.privat@gmail.com')
                ->subject('Time for Symfony Mailer!')

                ->htmlTemplate('mailer/mail.html.twig')
                ->context([
                    'place' => $place,
                    'content' => $content,
                ]);

            $mailer->send($email);
            $this->addFlash('success', 'Nachricht wurde an den Kellner gesendet');
            return $this->redirectToRoute('app_mail');
        }

        return $this->render('mailer/index.html.twig', [
            'emailForm' => $emailForm->createView(),
        ]);
    }
}
