<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        $ch="<html><head></head><body><h1>bonjour tout le monde</h1></body></html>";
        $reponse= new Response($ch);
        return $reponse;

       /* return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);*/
    }
    /**
     * @Route("/test/test2", name="test2")
     */
    public function index2(): Response
    {
        $tab=['Nouha','iheb','ibtissem','Eya'];
        $message='bonjour ccdad1 2020 2021';
        $reponse= $this->render('test/test2.html.twig', ['etudiants'=>$tab,'msg'=>$message]);
        return $reponse;
         
  
        
    }
    /**
     * @Route("/test3/{id}", name="test3")
     */
    public function index3($id): Response
    {
        $tab=['Ali','Mohamed','Iheb','Salah','foulen'];
        
        $reponse= $this->render('test/test3.html.twig', ['etudiant'=>$tab[$id]]);
        return $reponse;
         
  
        
    }


}
