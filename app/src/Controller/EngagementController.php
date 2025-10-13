<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Volunteer;
use App\Entity\Partner;
use App\Entity\Donation;
use App\Form\VolunteerType;
use App\Form\PartnerType;
use App\Form\DonationType;

class EngagementController extends AbstractController
{
    #[Route(path: '/benevole', name: 'app_volunteer')]
    public function volunteer(Request $request, EntityManagerInterface $em): Response
    {
        $volunteer = new Volunteer();
        $form = $this->createForm(VolunteerType::class, $volunteer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($volunteer);
            $em->flush();
            $this->addFlash('success', 'Merci pour votre engagement !');
            return $this->redirectToRoute('app_volunteer');
        }
        return $this->render('engagement/volunteer.html.twig', [ 'form' => $form->createView() ]);
    }

    #[Route(path: '/partenaire', name: 'app_partner')]
    public function partner(Request $request, EntityManagerInterface $em): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($partner);
            $em->flush();
            $this->addFlash('success', 'Merci pour votre soutien !');
            return $this->redirectToRoute('app_partner');
        }
        return $this->render('engagement/partner.html.twig', [ 'form' => $form->createView() ]);
    }

    #[Route(path: '/don', name: 'app_donation')]
    public function donation(Request $request, EntityManagerInterface $em): Response
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($donation);
            $em->flush();
            $this->addFlash('success', 'Merci pour votre don !');
            return $this->redirectToRoute('app_donation');
        }
        return $this->render('engagement/donation.html.twig', [ 'form' => $form->createView() ]);
    }
}


