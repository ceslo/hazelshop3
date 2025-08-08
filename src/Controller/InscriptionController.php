<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use App\Repository\TypeClientRepository;
use App\Repository\TypeUtilisateurRepository;
use App\Repository\UtilisateurRepository;
use App\Security\EmailVerifier;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class InscriptionController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier) {

    }

    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entitymanager, TypeUtilisateurRepository $typeUtilisateurRepo, TypeClientRepository $typeClientRepo, UtilisateurRepository $utilisateurRepo): Response
    {
        $form = $this->createForm(InscriptionType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur = $form->getData();
            //creation d'un nouvel utilisateur type CLIENT
            // $utilisateur= new Utilisateur();
            // $utilisateur=$data;
            // $utilisateur->setEmail($data['email']);
            // $utilisateur->setNom($data['nom']);
            // $utilisateur->setPrenom($data['prenom']);
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $utilisateur->setPassword($userPasswordHasher->hashPassword($utilisateur, $plainPassword));

            $utilisateur->setDateInscription(new DateTime());

            $typeUtilisateur = $typeUtilisateurRepo->findOneBy(['libelle_utilisateur' => 'client']);
            $utilisateur->setTypeUtilisateur($typeUtilisateur);

            $entitymanager->persist($utilisateur);
            $entitymanager->flush();

            // Creation d'un nouveau client type Particulier
            $client = new Client();
            // $telephone=$form->getData('telephone');
            // $client->setTelephone($telephone);
            $client->setCoefClient('1.35');
            $client->setNumClient('12345678');
            $client->setUtilisateur($utilisateur);
            $commercial = $utilisateurRepo->find(4);
            $client->setCommercial($commercial);

            $typeclient = $typeClientRepo->findOneBy(['libelle' => 'particulier']);
            $client->setTypeClient($typeclient);

            $entitymanager->persist($client);
            $entitymanager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                 $utilisateur,
                (new TemplatedEmail())
                    ->from(new Address('mailer@hazelshop.com', 'HazelShop'))
                    ->to((string) $utilisateur->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_accueil');
        }
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
            'form' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator,): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /** @var Utilisateur $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_accueil');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_accueil');
    }
}
