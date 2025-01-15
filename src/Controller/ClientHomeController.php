<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientHomeController extends AbstractController
{
    #[Route('/clientH/home', name: 'app_client_home')]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('client_home/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

}
