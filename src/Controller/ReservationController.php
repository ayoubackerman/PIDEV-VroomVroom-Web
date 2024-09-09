<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Trajet;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailerService;

use Symfony\Component\Mime\Email;

#[Route('/reservation')]

class ReservationController extends AbstractController
{
// cliennnnttt


#[Route('/get', name: 'app_reservation_indexc')]
public function indexc(EntityManagerInterface $entityManager ,PaginatorInterface $paginator, Request $request): Response
{

    
 #   $reservations = $entityManager
   #     ->getRepository(Reservation::class)
    #    ->findAll();
     #  return $this->render('client/Reservation/indexc.html.twig', [
      #     'reservations' => $reservations,
       #]);
       $reservations =$entityManager
       ->getRepository(Reservation::class)->createQueryBuilder('p')
        ->orderBy('p.idReservation', 'ASC')
        ->getQuery();

    // Paginate the results of the query
    $pagination = $paginator->paginate(
        // Doctrine Query, not results
        $reservations,
        // Define the page parameter
        $request->query->getInt('page', 1),
        // Items per page
        3
    );
    return $this->render('client/Reservation/indexc.html.twig',[
        'pagination'=>$pagination,
    ]);
  
}

#[Route('/client/new', name: 'app_reservation_newc', methods: ['GET', 'POST'])]
public function newc(Request $request, EntityManagerInterface $entityManager, \Swift_Mailer $mailer): Response
{
   $reservation = new Reservation();
   $form = $this->createForm(ReservationType::class, $reservation);
   $form->handleRequest($request);

   if ($form->isSubmitted() && $form->isValid()) {
       $entityManager->persist($reservation);
       $entityManager->flush();
       $id_Reservation=$reservation->getIdReservation();
       
       $to = $reservation->getIdUser()->getEmail();
       $message =( new \Swift_Message('Ton reservation est accepte et bien enrigistre'))
       ->setFrom('pidevmycompany2023@gmail.com')
       ->setTo($to)
       ->setBody('Bonjour Monieur , Votre reservation et accepte !');
   $mailer->send($message);
   $this->addFlash('message','Demande dinscription envoyé!');
  
       return $this->redirectToRoute('app_reservation_indexc', array ('id'=>$id_Reservation), Response::HTTP_SEE_OTHER);
   }

   return $this->renderForm('client/Reservation/newc.html.twig', [
       'reservation' => $reservation,
       'form' => $form,
   ]);
}


#[Route('/get/{idReservation}', name: 'app_reservation_showc', methods: ['GET'])]
public function showc(Reservation $reservation): Response
{
   return $this->render('client/Reservation/showc.html.twig', [
       'reservation' => $reservation,
   ]);
}

#[Route('/client/{idReservation}', name: 'app_reservation_deletec', methods: ['POST'])]
public function deletec(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
        $entityManager->remove($reservation);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_reservation_indexc', [], Response::HTTP_SEE_OTHER);
}

#[Route('/{idReservation}/edit', name: 'app_reservation_editc', methods: ['GET', 'POST'])]
    public function editc(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_indexc', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/Reservation/editc.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    






    // admin
    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
        
    }
    
   
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager
            ->getRepository(Reservation::class)
            ->findAll();
        
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

   

    #[Route('/{idReservation}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{idReservation}/client/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{idReservation}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getIdReservation(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }



   
}
