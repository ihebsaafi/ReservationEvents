<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\EventRepository;
use App\Repository\InscriptionRepository;
use App\Repository\ReservationRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EventRepository $ev, TicketRepository $ti,
                          CategorieRepository $cr,ReservationRepository $res, UserRepository $ur, EntityManagerInterface $em): Response
    {
        //Nombre des clients, des ticket, des catégories et des events
        $events = $ev->count();
        $categories = $cr->count();
        $tickets = $ti->count();
        $reservations = $res->count();
        $users = $ur->findAll();
        $clients = 0;
        foreach ($users as $u){
            if($u->getRoles() == ['ROLE_CLIENT']){
                $clients ++;
            }
        }

        //Events/categorie
        $query = $em->createQuery('select c.type as catnom, 
        count(e.id) as eventsCount
        from App\Entity\Categorie c Left join c.events e group by c.id');
        $categoriesData = $query->getResult();

        foreach ($categoriesData as &$data) {
            $data['eventsCount'] = (int) $data['eventsCount'];
        }

        return $this->render('home/index.html.twig',
            ['clientCount'=>$clients,
                'eventCount'=>$events,
                'inscriptionCount'=>$tickets,
                'categorieCount'=>$categories,
                'categorieData'=>$categoriesData]);
    }
}
