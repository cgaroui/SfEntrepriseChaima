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
    public function new(Request $request): Response
    {
        $entreprise = new Entreprise();
        
        
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        
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
