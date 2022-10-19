<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ContactType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request,
        EntityManagerInterface $manager,
        MailerInterface $mailer
        ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
        /// Saving in the Database
           $contact = $form->getData();
           $manager->persist($contact);
           $manager->flush();
        /// Sending an email
            $email = (new Email())
            ->from($contact->getEmail())
            ->to('admin@localhost')
            ->subject($contact->getSubject())
            ->text($contact->getMessage())
            ->html('<p>'.$contact->getMessage().'</p>');

            $mailer->send($email);

           $this->addFlash('success','Votre message a  bien été envoyé merci !');
           return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
