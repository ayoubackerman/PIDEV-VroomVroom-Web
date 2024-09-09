<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserjsonController extends AbstractController
{

    /**
     * @Route(("/user/signup", name: "app_service_register")
     */
    public function signupAction(Request $request)
    {
        $Email = $request->query->get("email");
        $Roles = $request->query->get("roles");
        $Password = $request->query->get("password");

        $Name = $request->query->get("nom");
        $LastName = $request->query->get("prenom");
        $Nomd = $request->query->get("nomd");
        $Numero = $request->query->get("num");

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            return new Response("email invalid.", 400);
        }

        $user = new User();
        $user->setEmail($Email);
        $user->setPassword($Password);
        $user->setNom($Name);
        $user->setPrenom($LastName);
        $user->setNomd($Nomd);
        $user->setNum($Numero);
        $user->setRoles(['1']);
        // $user->setIdRole(1);


        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("Account is cretaed", 200);
        } catch (\Exception $ex) {
            return new Response("exception :" . $ex->getMessage());
        }
    }



    /**
     * @Route("/user/details", name: "detailsCLient")
     */

    public function detailsCLient(UserRepository $userRepository, Request $request, NormalizerInterface $normalizer)
    {
        $id = $request->query->get("id");
        $user = $userRepository->find($id);
        $userlogin = $normalizer->normalize($user, 'json', ['groups' => "user"]);
        //  $json = json_encode($userlogin);
        return new JsonResponse($userlogin, 200);
    }

    /**
     * @Route("/listUser", name="allUser")
     */

    public function ListeUsers(UserRepository $cat, NormalizerInterface $normalizer): Response
    {
        $categorie = $cat->findAll();
        $js = $normalizer->normalize($categorie, 'json', ['groups' => 'user']);
        // $json=$serializerinterface->normalize($restaurant,'json',['groups'=>'restaurant']);
        // dump($restaurant);
        //die;
        //$formatted= $serializer->normalize($json);
        return new Response(json_encode($js));
    }




    /**
     * @Route("user/signin", name: "app_service_login")
     */

     public function siginAction(Request $request, NormalizerInterface $normalizer)
     {
         $Email = $request->query->get("email");
         $Password = $request->query->get("password");
 
         $em = $this->getDoctrine()->getManager();
         $user = $em->getRepository(User::class)->findOneBy(['email' => $Email]);
 
         if ($user) {
 
             if ($Password == $user->getPassword()) {
                 if ($user->getRoles()[0] == '1') {
                     $userlogin = $normalizer->normalize($user, 'json', ['groups' => "user"]);
                 } else {
                     $userlogin = $normalizer->normalize($user, 'json', ['groups' => "user"]);
                 }
                 //  $json = json_encode($userlogin);
                 return new JsonResponse($userlogin, 200);
             } else {
                 return new JsonResponse("password not found", 500);
             }
         } else {
             return new JsonResponse("No User founded", 300);
         }
     }

    
    /**
     * @Route("/user/deleteUser", name: "delete_User")
     */
    public function deletePostAction(Request $request)
    {

        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $Post = $em->getRepository(User::class)->find($id);
        if ($Post != null) {
            $em->remove($Post);
            $em->flush();

            $serialize = new Serializer([new ObjectNormalizer()]);
            $formatted = $serialize->normalize("utilisateur a ete supprimee avec success.");
            return new JsonResponse($formatted);
        }
        return new JsonResponse("id Post invalide.");
    }


    #[Route("user/editUser", name: "app_gestion_profile")]
    public function editUser(Request $request, UserPasswordEncoderInterface $PasswordEncoder)
    {
        $id = $request->query->get("id");
        $Name = $request->query->get("nom");
        //$Numero = $request->query->get("Numero");
        $Email = $request->query->get("email");
        //$Adresse = $request->query->get("Adresse");
        $Password = $request->query->get("password");
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($id);

        // if($request->files->get("photo") != null)
        // {
        //  $file = $request->files->get("photo");
        // $fileName = $file->getClientOriginalName();
        // $file->move(
        //   $fileName
        //  );
        // $user->setCIN($CIN);
        $user->setName($Name);
        //$user->setNumero($Numero);
        $user->setEmail($Email);
        // $user->setAdresse($Adresse);
        $user->setPassword(
            $PasswordEncoder->encodePassword(
                $user,
                $Password
            )
        );

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success", 200);
        } catch (\Exception $ex) {
            return new Response("failed" . $ex->getMessage());
        }
    }


    #[Route("user/details", name: "details_User")]
    public function details_User(Request $request, UserRepository $userRepository, NormalizerInterface $normalizer)
    {
        $id = $request->get("id");
        $user = $userRepository->find($id);
        if ($user != null) {
            $userlogin = $normalizer->normalize($user, 'json', ['groups' => "user"]);
            return new JsonResponse($userlogin, 200);
        }
        return new JsonResponse("id Post invalide.");
    }
}
