<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use MercurySeries\FlashyBundle\FlashyNotifier;

#[Route('/voiture')]
class VoitureController extends AbstractController
{
    #[Route('/', name: 'app_voiture_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $voitures = $entityManager
            ->getRepository(Voiture::class)
            ->findAll();

        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FlashyNotifier $flashy ): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voiture);
            $entityManager->flush();
            $flashy->warning('voiture ajouté avec succès !', 'http://your-awesome-link.com');

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{idVoiture}', name: 'app_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

    #[Route('/{idVoiture}/edit', name: 'app_voiture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{idVoiture}', name: 'app_voiture_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getIdVoiture(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }

    /*
    #[Route('/{id}', name: 'app_voiture_pdf', methods: ['GET'])]
     
public function pdf( Voiture $voiture): Response
{
    // create new PDF document
    $dompdf = new Dompdf();
    
    // generate HTML content for the document
    $html = $this->renderView('voiture/pdf.html.twig', [
        'voiture' => $voiture, 
        
    ]);

    // load HTML into the PDF document
    $dompdf->loadHtml($html);

    // render PDF document
    $dompdf->render();

    // create a response object to return the PDF file
    $response = new Response($dompdf->output());
    $dompdf->output('test.pdf', 'F');
    // set content type to application/pdf
    $response->headers->set('Content-Type', 'application/pdf');

    $disposition = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_INLINE,
        'voiture.pdf'
    );
    $response->headers->set('Content-Disposition', $disposition);

    return $response;
}

*/

#[Route('/{id}', name: 'app_voiture_pdf', methods: ['GET'])]
     
    public function download()
    {
        //definit les option pdf
        $pdfOptions = new Options();
        //police
        $pdfOptions->set('defaultFont', 'Arial');
        // resoudre les prob lié au ssl
        $pdfOptions->setIsRemoteEnabled(true);
        // On instancie Dompdf
        $dompdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($context);
        // On génère le html
        $html = $this->renderView('voiture/pdf.html.twig');

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        // On envoie le PDF au navigateur
        $dompdf->stream("mypdf.pdf", [
            'Attachment' => true    //méthode de stream qui va permettre de telechaarger
        ]);

        return new Response();
    }
}
