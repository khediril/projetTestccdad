<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use App\Service\MessageGenerator;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class ProductController extends AbstractController
{
    /**
     * @Route("/product/add/{nom}/{desc}/{prix}/{quant}", name="product")
     */
    public function index($nom, $desc, $prix, $quant, EntityManagerInterface $em): Response
    {
        $produit = new Produit();
        $produit->setNom($nom);
        $produit->setDescription($desc);
        $produit->setPrix($prix);
        $produit->setQuantite($quant);

        $em->persist($produit);

        $em->flush();

        return $this->render('product/add.html.twig', ['prod' => $produit]);
    }
    /**
     * @Route("/product/list", name="produit_list")
     * @IsGranted("ROLE_ADMIN")
     */
    public function getProduits(ProduitRepository $repo, LoggerInterface $logger): Response
    {
        $produits = $repo->findAll();
        //$produits=$this->getDoctrine()->getRepository(Produit::class)->findProduitEnPromo();
        $logger->info("Accés à liste des produits ");
        $user = $this->getUser();
        //dd($user);

        return $this->render('product/liste.html.twig', ['produits' => $produits,'username'=>$user->getUsername()]);
    }
    /**
     * @Route("/product/{id}", name="produit_detail")
     */
    public function getProduit(ProduitRepository $repo, $id): Response
    {
        $produit = $repo->find($id);
        //$produits=$this->getDoctrine()->getRepository(Produit::class)->findProduitEnPromo();
        // if(!$produit)
        //throw $this->createNotFoundException('Ce produit n\'existe pas');

        return $this->render('product/detail.html.twig', ['p' => $produit]);
    }
    /**
     * @Route("/product/listparprix/{pmin}/{pmax}", name="produit_list_parprix")
     */
    public function getProduitsParPrix(ProduitRepository $repo, $pmin, $pmax): Response
    {
        $produits = $repo->chercherParPrix($pmin, $pmax);
        //$produits=$this->getDoctrine()->getRepository(Produit::class)->findProduitEnPromo();


        return $this->render('product/listeparprix.html.twig', ['produits' => $produits, 'pmin' => $pmin, 'pmax' => $pmax]);
    }
    /**
     * @Route("/product1/ajout", name="produit_add")
     */
    public function addProduit(Request $request,MessageGenerator $messageGenerator): Response
    {

        $produit = new Produit();
        // $task->setTask('Write a blog post');
        // $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($produit)
            ->add('nom', TextType::class)
            ->add('description', TextType::class)
            ->add('prix', IntegerType::class)
            ->add('quantite', IntegerType::class)
            ->add('Categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',

            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter produit'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            //$task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();
            $message = $messageGenerator->getHappyMessage();
            $this->addFlash('success', $message);
            return $this->redirectToRoute('produit_list');
        }

        return $this->render('product/ajoutproduit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
