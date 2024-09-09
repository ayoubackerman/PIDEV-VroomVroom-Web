<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Repository\ReponseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Reclamation;

class ReponsejsonController extends AbstractController
{
  /**
     * @Route("/listjsonr", name="Reponse_json")
     */
    public function ListReponseJson(ReponseRepository $cat, NormalizerInterface $normalizer): Response
    {
        $Reponse=$cat->findAll();
        $js=$normalizer->normalize($Reponse,'json',['groups'=>'post:read']);
        return new Response(json_encode($js));
    }
/**
 * @Route("/addReponseJSON",name="addReponseJSON")
 */
public function addReponseJSON(Request $request, SerializerInterface $serializer)
{
    $em = $this->getDoctrine()->getManager();
    $reclamationId = $request->get('id_reclamation');
    $reclamation = $em->getRepository(Reclamation::class)->find($reclamationId);

    $reponse = new Reponse();
    $reponse->setReponse("En cours de traitement......	");
    $reponse->setIdReclamation($reclamation->getIdReclamation()); // pass the ID of the Reclamation object
    $em->persist($reponse);
    $em->flush();
    $jsonContent = $serializer->serialize($reponse, 'json', [
        'circular_reference_handler' => function ($object) {
            return $object->getId();
        }
    ]);

    // On instancie la réponse
    $response = new Response($jsonContent);

    // On ajoute l'entête HTTP
    $response->headers->set('Content-Type', 'application/json');

    // On envoie la réponse
    return $response;
}


    /**
     * @Route("/deleteReponseJSON/{id}",name="deleteReponseJSON")
     */

    public function deleteReponseJSON(Request $request,SerializerInterface  $serializer, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat=$em->getRepository(Reponse::class)->find($id);
        $em->remove($cat);
        $em->flush();
        $jsonContent = $serializer->serialize($cat, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }  ],
        );
        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;


    }
    /**
     * @Route("/updateReponseJSON/{id}",name="updateReponseJSON")
     */
    public function updateReponseJSON(Request $request, SerializerInterface $serializer, $id)
    {
        $em = $this -> getDoctrine()->getManager();
        $cat = $em->getRepository(Reponse::class)->find($id);
        $cat->setReponse($request->get('Reponse'));
        $em->flush();
        $jsonContent = $serializer->serialize($cat, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }  ],
        );

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;

    }
}
