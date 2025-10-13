<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VolunteerRepository;
use App\Repository\PartnerRepository;
use App\Repository\DonationRepository;
use App\Repository\ContactMessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ContactMessage;

#[Route(path: '/admin')]
class AdminController extends AbstractController
{
    #[Route(path: '/', name: 'app_admin_dashboard')]
    public function index(
        VolunteerRepository $volunteerRepo,
        PartnerRepository $partnerRepo,
        DonationRepository $donationRepo,
        ContactMessageRepository $contactRepo
        ): Response
    {
        return $this->render('admin/index.html.twig', [
            'volunteers' => $volunteerRepo->findBy([], ['id' => 'DESC']),
            'partners' => $partnerRepo->findBy([], ['id' => 'DESC']),
            'donations' => $donationRepo->findBy([], ['id' => 'DESC']),
            'messages' => $contactRepo->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route(path: '/message/{id}/repondre', name: 'app_admin_reply')]
    public function reply(ContactMessage $message, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $reply = trim((string) $request->request->get('reply'));
            if ($reply !== '') {
                $message->setReply($reply);
                $message->setRepliedAt(new \DateTimeImmutable());
                $em->flush();
                $this->addFlash('success', 'Réponse enregistrée.');
                return $this->redirectToRoute('app_admin_dashboard');
            }
            $this->addFlash('danger', 'La réponse ne peut pas être vide.');
        }
        return $this->render('admin/reply.html.twig', [ 'message' => $message ]);
    }
}


