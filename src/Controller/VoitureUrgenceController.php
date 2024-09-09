<?php

namespace App\Controller;

use App\Entity\VoitureUrgence;
use App\Form\VoitureUrgenceType;
use App\Repository\VoitureUrgenceRepository;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


#[Route('/voiture/urgence')]
class VoitureUrgenceController extends AbstractController
{
    #[Route('/', name: 'app_voiture_urgence_index', methods: ['GET'])]
    public function index(VoitureUrgenceRepository $voitureUrgenceRepository , Request $request): Response
    {
        $page = $request->query->getInt('page',1);

        $voitureUrgence = $voitureUrgenceRepository->findVoitureUrgence($page,2);


        return $this->render('voiture_urgence/index.html.twig', [
            'voiture_urgences' => $voitureUrgence,
        ]);
    }
    #[Route('/', name: 'voiture_urgence_index', methods: ['GET'])]
    public function indexx(VoitureUrgenceRepository $voitureUrgenceRepository , Request $request): Response
    {
        $page = $request->query->getInt('page',1);

        $voitureUrgence = $voitureUrgenceRepository->findVoitureUrgence($page,2);


        return $this->render('voiture_urgence/index.html.twig', [
            'voiture_urgences' => $voitureUrgence,
        ]);
    }

    #[Route('/new', name: 'app_voiture_urgence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VoitureUrgenceRepository $voitureUrgenceRepository,SluggerInterface $slugger): Response
    {
        $voitureUrgence = new VoitureUrgence();
        $form = $this->createForm(VoitureUrgenceType::class, $voitureUrgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();


            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    dd("erruer " +  $e->toString());
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $voitureUrgence->setImage($newFilename);
            }
            $voitureUrgenceRepository->save($voitureUrgence, true);

            return $this->redirectToRoute('app_voiture_urgence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture_urgence/new.html.twig', [
            'voiture_urgence' => $voitureUrgence,
            'form' => $form,
        ]);
    }

    #[Route('/{idVoiture}', name: 'app_voiture_urgence_show', methods: ['GET'])]
    public function show(VoitureUrgence $voitureUrgence): Response
    {
        return $this->render('voiture_urgence/show.html.twig', [
            'voiture_urgence' => $voitureUrgence,
        ]);
    }

    #[Route('/{idVoiture}/edit', name: 'app_voiture_urgence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VoitureUrgence $voitureUrgence, VoitureUrgenceRepository $voitureUrgenceRepository): Response
    {
        $form = $this->createForm(VoitureUrgenceType::class, $voitureUrgence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voitureUrgenceRepository->save($voitureUrgence, true);

            return $this->redirectToRoute('app_voiture_urgence_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture_urgence/edit.html.twig', [
            'voiture_urgence' => $voitureUrgence,
            'form' => $form,
        ]);
    }

    #[Route('/{idVoiture}', name: 'app_voiture_urgence_delete', methods: ['POST'])]
    public function delete(Request $request, VoitureUrgence $voitureUrgence, VoitureUrgenceRepository $voitureUrgenceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voitureUrgence->getIdVoiture(), $request->request->get('_token'))) {
            $voitureUrgenceRepository->remove($voitureUrgence, true);
        }

        return $this->redirectToRoute('app_voiture_urgence_index', [], Response::HTTP_SEE_OTHER);
    }










}


//use knp\snappy\pdf;