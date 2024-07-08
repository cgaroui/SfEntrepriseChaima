<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployerController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
        $employes = $employeRepository->findBy([],["nom" =>"ASC"]);
        return $this->render('employe/index.html.twig', [
           'employes' => $employes
        ]);
    }

    
    #[Route('/employe/new', name: 'new_employe')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employe = new Employe();
        
        
        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);

        //je verifie si mes champs ont été correctement remplis et mon formulaire bien soumis
        if ($form->isSubmitted() && $form->isValid()) {

            $employe = $form->getData();
            //ici persist est equivalent à prepare(),il prepare la requete 
            $entityManager->persist($employe);
            //et flush() est equivalent à lamethode excute()-> pr exécuter la requete 
            $entityManager->flush();

            //on veut retourne la liste des employé pour voir si l'enregistrement d'un nv employé a été pris en compte c'est pour ça on redirige vers app_employé qui liste les employés
            return $this->redirectToRoute('app_employe');     
        }
        
        return $this->render('employe/new.html.twig', [
            'formAddEmploye' => $form,
        ]);
    }
    
    #[Route('/employe/{id}', name: 'show_employe')]
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $employe
         ]);
    }
}
  
