<?php

namespace App\Controller;

use DateTime;
use App\Entity\Reclamation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReclamationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReclamationjsonController extends AbstractController
{
   /**
     * @Route("/listjson", name="Reclamation_json")
     */
    public function ListReclamationJson(ReclamationRepository $cat, NormalizerInterface $normalizer): Response
    {
        $Reclamation=$cat->findAll();
        $js=$normalizer->normalize($Reclamation,'json',['groups'=>'post:read']);
        return new Response(json_encode($js));
    }

    /**
     * @Route("/addReclamationJSON/",name="addReclamationJSON")
     */
    public function addReclamationJSON(Request $request, SerializerInterface $serializer, UserRepository $repouser)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = new Reclamation();
        $useer = $this->getUser();
    
        if (!$useer) {
            return new JsonResponse(['error' => 'User not found'], 400);
        } else {
            $usr = $repouser->find($useer);
            $cat->setIdUser($usr);
            $cat->setReclamation($request->get('reclamation'));
            $cat->setTypeReclamation($request->get('type_Reclamation'));
            $cat->setTemps(new DateTime('@' . strtotime('now')));
    
            $em->persist($cat);
            $em->flush();
    
            $response = ['success' => true];
            return new JsonResponse($response, 200);
        }
    
    
       
        $em->persist($cat);
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
     * @Route("/deleteReclamationJSON/{id}",name="deleteReclamationJSON")
     */

    public function deleteReclamationJSON(Request $request,SerializerInterface  $serializer, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat=$em->getRepository(Reclamation::class)->find($id);
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
     * @Route("/updateReclamationJSON/{id}",name="updateReclamationJSON")
     */
    public function updateReclamationJSON(Request $request, SerializerInterface $serializer, $id)
    {
        $em = $this -> getDoctrine()->getManager();
        $cat = $em->getRepository(Reclamation::class)->find($id);
        $cat->setReclamation($request->get('reclamation'));
        $cat->setTypeReclamation($request->get('type_Reclamation'));

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
     * @Route("/api/countByTypeReclamation/", name="hggggg")
     */
    public function total(ReclamationRepository $cat, NormalizerInterface $normalizer): Response
    {
        $Reclamation=$cat->TotalReclamation();
        $js=$normalizer->normalize($Reclamation,'json',['groups'=>'post:read']);
        return new Response(json_encode($js));
    }



//    /**
//      * @Route("/api/stat/", name="stat")
//      */
//     public function stat(EntityManagerInterface $entityManager)
//     {
//         $rec = $entityManager->getRepository(Reclamation::class)->findAll();
//         // Get the statistics
//         $stats = $entityManager->createQueryBuilder()
//             ->select('r.typeReclamation, COUNT(r.idReclamation) as num_reclamations')
//             ->from(Reclamation::class, 'r')
//             ->groupBy('r.typeReclamation')
//             ->getQuery()
//             ->getResult();
//             return new Response(json_encode($stats));

//     }
}
