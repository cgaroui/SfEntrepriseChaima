<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'app_entreprise')]

    public function index(EntityManagerInterface $entityManager): Response
    {
        
        $entreprises = $entityManager->getRepository(Entreprise::class)->findAll();
        return $this->render('entreprise/index.html.twig', [
           'entreprises' => $entreprises
        ]);
    }

    
    
    #[Route('/entreprise/new', name: 'new_entreprise')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entreprise = new Entreprise();
        
        
        $form = $this->createForm(EntrepriseType::class, $entreprise);

        
        $form->handleRequest($request);

        //je verifie si mes champs ont été correctement remplis et mon formulaire bien soumis
        if ($form->isSubmitted() && $form->isValid()) {

            $entreprise = $form->getData();
            //ici persist est equivalent à prepare(),il prepare la requete 
            $entityManager->persist($entreprise);
            //et flush() est equivalent à lamethode excute()-> pr exécuter la requete 
            $entityManager->flush();

            //on veut retourne la liste des entreprises pour voir si l'enregistrement d'une nvl entreprise a été pris en compte c'est pour ça on redirige vers app_entreprise qui liste les entreprises
            return $this->redirectToRoute('app_entreprise');     
        }
        
        return $this->render('entreprise/new.html.twig', [
            'formAddEntreprise' => $form,
        ]);
    }

    //id ici la clé primaire de l'objet qu'on veut recuperer 
    #[Route('/entreprise/{id}', name: 'show_entreprise')]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise
         ]);
    }
}
