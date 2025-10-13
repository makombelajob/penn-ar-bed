<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ContactMessage;
use App\Form\ContactMessageType;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Merci pour votre message !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}


