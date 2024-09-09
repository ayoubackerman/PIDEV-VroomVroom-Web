<?php




namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PdfTrajApiController extends AbstractController
{
    /**
 * @Route("/api/generate-pdf/{id}/{trajet}", name="api_generate_pdf", methods={"GET"})
 */
    public function generatePdf($id , $trajet)
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
      /*var_dump($trajet) ; 
      die() ; */
        $html = $this->renderView( 'pdf/pdf.html.twig' , ["id"=> $id , "trajet" =>$trajet ]);


        $dompdf->loadHtml($html);
        $dompdf->render();

        $output = $dompdf->output();

        $response = new Response($output);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="pdf.pdf"');

        return $response;
    }
}