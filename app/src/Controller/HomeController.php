<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactForm;
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
    public function volunteers(): Response
    {
        return $this->render('home/volunteers.html.twig');
    }

    #[Route('/partenariat', name: 'app_paterns')]
    public function paterns(): Response
    {
        return $this->render('home/paterns.html.twig');
    }

    #[Route('/faire-un-don', name: 'app_gifts')]
    public function gifts(): Response
    {
        return $this->render('home/gifts.html.twig');
    }

}
