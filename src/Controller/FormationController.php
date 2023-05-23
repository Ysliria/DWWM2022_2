<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'formation_index')]
    public function index(FormationRepository$formationRepository): Response
    {
        $formations = $formationRepository->findAll();

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    #[Route('/formation/add', name: 'formation_add', methods: ['POST', 'GET'])]
    public function add(Request $request, FormationRepository $formationRepository): Response
    {
        $formation = new Formation();
        $formationAdd   = $this->createForm(FormationType::class, $formation);

        $formationAdd->handleRequest($request);

        if ($formationAdd->isSubmitted() && $formationAdd->isValid()) {
            $formationRepository->save($formation, true);

            // @todo : ajouter une redirection vers l'index après la création
        }

        return $this->render('formation/add.html.twig', [
            'formation_add' => $formationAdd
        ]);
    }
}
