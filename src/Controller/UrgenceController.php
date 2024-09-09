<?php

namespace App\Controller;

use App\Entity\Urgence;
use App\Form\UrgenceType;
use App\Repository\UrgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;



#[Route('/urgence')]
class UrgenceController extends AbstractController
{


    public function SendSMS(string $to, string $message)
    {
        $sid = 'ACe0169bd0b1ce34ea88aa4cfb44d11c38';
        $token = '6141e9a98c9526c95659d4d2b0b428bf';
        $twilioNumber = '+16204559261';

        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                $to,
                [
                    'from' => $twilioNumber,
                    'body' => $message,
                ]
            );
        } catch (TwilioException $e) {
            // Handle Twilio exception here
            echo 'Error: ' . $e->getMessage();
        }
    }



    #[Route('/stat', name: 'stats', methods: ['GET'])]
    public function statistiques(UrgenceRepository $urgRepo)
    {

        // On va chercher toutes les catégories
        $urgences = $urgRepo->findAll();

        $urgNonTraite = 0;
        $urgTerminer = 0;
        $urgEnCour = 0;

        // On "démonte" les données pour les séparer tel qu'attendu par ChartJS
        foreach ($urgences as $urgence) {
            if ($urgence->getStatuts()==0){
                $urgNonTraite += 1;
            }elseif ($urgence->getStatuts()==1){
                $urgEnCour +=1;
            }else
                $urgTerminer +=1;
        }

        return $this->render('urgence/stats.html.twig', [
            'urgNonTraite' =>json_encode($urgNonTraite),
            'urgEnCour' =>json_encode($urgEnCour),
            'urgTerminer' =>json_encode($urgTerminer)
        ]);
    }



    #[Route('/', name: 'app_urgence_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, UrgenceRepository $urgenceRepository ,Request $request)
    {

        $urgences = $entityManager
            ->getRepository(Urgence::class)
            ->findAll();



        //on recupére les filtres
       // $filters = $request->get("urgences");
        //on verifie si on a une requete ajax


        if ($request->get('ajax')){

            $chaine=$request->get('0');
            $chaine1=$request->get('1');
            $chaine2=$request->get('2');

            if (is_null($chaine)) {
                $chaine='';

            }
            if (is_null($chaine1)) {
                $chaine1='';

            }
            if (is_null($chaine2)) {
                $chaine2='';

            }


            $urgences = $entityManager
                ->getRepository(Urgence::class)
                ->findAllUrgences($chaine,$chaine1,$chaine2);
            if (($chaine=='') && ($chaine1=='') && ($chaine2==''))
                $urgences = $entityManager
                    ->getRepository(Urgence::class)
                    ->findAll();

                return new JsonResponse([
                    'content' => $this->renderView('urgence/_content.html.twig', compact('urgences'))
                ]);
            }


        return $this->render('urgence/index.html.twig', [
            'urgences' => $urgenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_urgence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UrgenceRepository $urgenceRepository): Response
    {
        $urgence = new Urgence();
        $form = $this->createForm(UrgenceType::class, $urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $urgenceRepository->save($urgence, true);
            $urgence->setStatuts("0");
            $urgence->setIdVoiture(Null);
            $to = '+21652214491'; // Replace with recipient's phone number
            $message = 'nous sommes en routes.'; // Replace with desired SMS message
            $this->SendSMS($to, $message);

            return $this->redirectToRoute('app_urgence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('urgence/new.html.twig', [
            'urgence' => $urgence,
            'f' => $form,
        ]);
    }

    #[Route('/{idUrgence}', name: 'app_urgence_show', methods: ['GET'])]
    public function show(Urgence $urgence): Response
    {
        return $this->render('urgence/show.html.twig', [
            'urgence' => $urgence,
        ]);
    }

    #[Route('/{idUrgence}/edit', name: 'app_urgence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Urgence $urgence, UrgenceRepository $urgenceRepository): Response
    {
        $form = $this->createForm(UrgenceType::class, $urgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $urgenceRepository->save($urgence, true);
            return $this->redirectToRoute('app_urgence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('urgence/edit.html.twig', [
            'urgence' => $urgence,
            'f' => $form,
        ]);
    }

    #[Route('/{idUrgence}', name: 'app_urgence_delete', methods: ['POST'])]
    public function delete(Request $request, Urgence $urgence, UrgenceRepository $urgenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$urgence->getIdUrgence(), $request->request->get('_token'))) {
            $urgenceRepository->remove($urgence, true);
        }

        return $this->redirectToRoute('app_urgence_index', [], Response::HTTP_SEE_OTHER);
    }





    }
