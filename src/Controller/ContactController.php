<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $mail = new TemplatedEmail();
            $mail->from($contact['from'])
                 ->to ('contact@hazelshop.com')
                 ->subject($contact['sujet'])
                 ->text($contact['message']);

            $mailer->send($mail);
            $this->addFlash('success','Votre message a bien été envoyé, notre equipe vous recontactera dans un delais de 48h');

           return $this->redirectToRoute('app_accueil');    
        };

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form
        ]);
    }
}
