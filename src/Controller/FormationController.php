<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formation', name: 'formation_')]
class FormationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    #[Route('/{formation}/detail', name: 'show')]
    public function show(Formation $formation)
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation
        ]);
    }

    #[Route('/ajouter', name: 'add', methods: ['POST', 'GET'])]
    public function add(Request $request, FormationRepository $formationRepository): Response
    {
        $formation    = new Formation();
        $formationAdd = $this->createForm(FormationType::class, $formation);

        $formationAdd->handleRequest($request);

        if ($formationAdd->isSubmitted() && $formationAdd->isValid()) {
            $formationRepository->save($formation, true);

            return $this->redirectToRoute(
                'formation_show',
                ['formation' => $formation->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('formation/add.html.twig', [
            'formation_add' => $formationAdd
        ]);
    }
}
