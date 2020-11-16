<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/add/{nom}/{desc}/{prix}/{quant}", name="product")
     */
    public function index($nom,$desc,$prix,$quant,EntityManagerInterface $em): Response
    {
        $produit=new Produit();
        $produit->setNom($nom);
        $produit->setDescription($desc);
        $produit->setPrix($prix);
        $produit->setQuantite($quant);
       
        $em->persist($produit);
        
        $em->flush();
        
        return $this->render('product/add.html.twig', ['prod'=>$produit ]);
    }
    /**
     * @Route("/product/list", name="produit_list")
     */
    public function getProduits(ProduitRepository $repo): Response
    {
         $produits=$repo->findAll();
         //$produits=$this->getDoctrine()->getRepository(Produit::class)->findProduitEnPromo();
        
        
        return $this->render('product/liste.html.twig', ['produits'=>$produits ]);
    }
    /**
     * @Route("/product/{id}", name="produit_detail")
     */
    public function getProduit(ProduitRepository $repo,$id): Response
    {
         $produit=$repo->find($id);
         //$produits=$this->getDoctrine()->getRepository(Produit::class)->findProduitEnPromo();
   // if(!$produit)
            //throw $this->createNotFoundException('Ce produit n\'existe pas');
        
        return $this->render('product/detail.html.twig', ['p'=>$produit ]);
    }
}
