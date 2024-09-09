<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Repository\TrajetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
#[Route('/trajet')]
class TrajetController extends AbstractController
{


    
    #[Route('/show_in_map/{idTrajet}', name: 'app_trajet_map', methods: ['GET'])]
    public function Map( Trajet $idTrajet,EntityManagerInterface $entityManager ): Response
    {

        $idTrajet = $entityManager
            ->getRepository(Trajet::class)->findBy( 
                ['idTrajet'=>$idTrajet ]
            );
        return $this->render('trajet/api_arcgis.html.twig', [
            'trajet' => $idTrajet,
        ]);
    }



    #[Route('/', name: 'app_trajet_index', methods: ['GET','POST'])]


    
    public function index(ManagerRegistry $doctrine,Request $request,TrajetRepository $TrajetRepository ,EntityManagerInterface $entityManager): Response
    {
        $trajets = $entityManager
        ->getRepository(Trajet::class)
        ->findAll();
    $back = null;
        
        if($request->isMethod("POST")){
            if ( $request->request->get('optionsRadios')){
                $SortKey = $request->request->get('optionsRadios');
                switch ($SortKey){
                    case 'villeDepart':
                        $trajets = $TrajetRepository->SortByvilleDepart();
                        break;

                    case 'villeDarrive':
                        $trajets = $TrajetRepository->SortByvilleDarrive();
                        break;

                    case 'modePaiement':
                        $trajets = $TrajetRepository->SortBymodePaiement();
                        break;
                }
            }
            else
            {
                $type = $request->request->get('optionsearch');//nekhdhou type mte3 recherche soit par titre wela par date wela par description
                $value = $request->request->get('Search'); //nekhdhou lvaleur mte3 input (par ex ibtihel )
                switch ($type){
                    case 'villeDepart':
                        $trajets = $TrajetRepository->findByvilleDepart($value);
                        break;

                    case 'villeDarrive':
                        $trajets = $TrajetRepository->findByvilleDarrive($value);
                        break;

                    case 'modePaiement':
                        $trajets = $TrajetRepository->findBymodePaiement($value);
                        break;
                }
            }

            if ( $trajets ){
                $back = "success";
            }
            else{
                $back = "failure";
            }
        }
    
    return $this->render('trajet/index.html.twig', [
        'trajets'=>$trajets,
        'back' => $back,
    ]);
    }
// client_tri_recherche
    

  



    #[Route('/clientTrajet', name: 'app_trajet_index_client', methods: ['GET'])]
    public function index_client(TrajetRepository $trajetRepository): Response
    {
        return $this->render('client/trajet/index.html.twig', [
            'trajets' => $trajetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_trajet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trajet);
            $entityManager->flush();

            return $this->redirectToRoute('app_trajet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trajet/new.html.twig', [
            'trajet' => $trajet,
            'form' => $form,
        ]);
    }

    #[Route('/{idTrajet}', name: 'app_trajet_show', methods: ['GET'])]
    public function show(Trajet $trajet): Response
    {
        return $this->render('trajet/show.html.twig', [
            'trajet' => $trajet,
        ]);
    }

    #[Route('/{idTrajet}/edit', name: 'app_trajet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trajet $trajet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_trajet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trajet/edit.html.twig', [
            'trajet' => $trajet,
            'form' => $form,
        ]);
    }

    #[Route('/{idTrajet}', name: 'app_trajet_delete', methods: ['POST'])]
    public function delete(Request $request, Trajet $trajet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trajet->getIdTrajet(), $request->request->get('_token'))) {
            $entityManager->remove($trajet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_trajet_index', [], Response::HTTP_SEE_OTHER);
    }
}
