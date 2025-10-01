<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Volunteers;
use App\Form\ContactForm;
use App\Form\PartnersType;
use App\Form\VolunteersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(ContactForm::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('Message Envoyé avec success', 'success');
            return $this->redirectToRoute('app_home/#contact');
        }
        return $this->render('home/index.html.twig', compact('form'));
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    #[Route('/benevole', name: 'app_volunteers')]
    public function volunteers(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(VolunteersType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($form->getData());
            $entityManagerInterface->flush();
            $this->addFlash('success', 'Formulaire envoyé');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/volunteers.html.twig', compact('form'));
    }

    #[Route('/partenariat', name: 'app_partners')]
    public function partners(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form = $this->createForm(PartnersType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($form->getData());
            $entityManagerInterface->flush();
            $this->addFlash('success', 'Formulaire envoyé');
            return $this->redirectToRoute('app_home');
            
        }
        return $this->render('home/partners.html.twig', compact('form'));
    }

    #[Route('/faire-un-don', name: 'app_gifts')]
    public function gifts(): Response
    {
        return $this->render('home/gifts.html.twig');
    }

}
