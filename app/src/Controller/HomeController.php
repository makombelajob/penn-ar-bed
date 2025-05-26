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

    #[Route('/action', name: 'app_action')]
    public function action(): Response
    {
        return $this->render('home/action.html.twig');
    }
}
