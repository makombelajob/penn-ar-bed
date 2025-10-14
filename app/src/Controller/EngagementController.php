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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

            // --- Persister la donation dans la base ---
            $em->persist($donation);
            $em->flush();

            // --- Stripe Checkout Session ---
            \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Don pour la société de solidarité',
                        ],
                        'unit_amount' => $donation->getAmount() * 100, // en centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $this->generateUrl('app_donation_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl('app_donation_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            // --- Redirection vers Stripe ---
            return $this->redirect($session->url);
        }
        return $this->render('engagement/donation.html.twig', ['form' => $form->createView()]);
    }
    // === ROUTES DE SUCCÈS ET ANNULATION ===
    #[Route(path: '/don/success', name: 'app_donation_success')]
    public function success(): Response
    {
        $this->addFlash('success', 'Merci pour votre don !');
        return $this->redirectToRoute('app_donation');
    }

    #[Route(path: '/don/cancel', name: 'app_donation_cancel')]
    public function cancel(): Response
    {
        $this->addFlash('error', 'Le paiement a été annulé.');
        return $this->redirectToRoute('app_donation');
    }
}


