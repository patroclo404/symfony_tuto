<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
//use Symfony\Component\Serializer\Encoder\JsonEncoder;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert ;
//use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    public function pruebasAction(Request $request)
    {
        $helpers = $this->get("app.helpers");


        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('BackendBundle:User')->findAll();
        /*var_dump($users);
        die();*/
        return $helpers->json1($users);
    }

    public function loginAction(Request $request)
    {
        # code...
        $helpers = $this->get("app.helpers");
        $json = $request->get("json", null);

        if( $json != null ){
            $json = json_decode($json);
            $email = (isset($json->email)) ? $json->email : null ;
            $pass = (isset($json->password)) ? $json->password : null ;

            $emailContraint = new Assert\Email();
            $emailContraint->message = "This mail is not valid!!";

            $validate_email = $this->get("validator")->validate($email,$emailContraint);
        }else
            echo "Send json with post !!!";

        die();
    }


}
