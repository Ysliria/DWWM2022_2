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

    #[Route('/{formation}/detail', name: 'show', methods: ['GET'])]
    public function show(Formation $formation): Response
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

            $this->addFlash('success', 'La formation " ' . $formation->getNom() . ' " a bien été créée !');

            return $this->redirectToRoute(
                'formation_show',
                ['formation' => $formation->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('formation/add.html.twig', [
            'formation_form' => $formationAdd
        ]);
    }

    #[Route('/{formation}/modifier', name: 'update', methods: ['POST', 'GET'])]
    public function update(Formation $formation, Request $request, FormationRepository $formationRepository): Response
    {
        $formationUpdate = $this->createForm(FormationType::class, $formation);
        $formationUpdate->handleRequest($request);

        if ($formationUpdate->isSubmitted() && $formationUpdate->isValid()) {
            $formationRepository->save($formation, true);

            $this->addFlash('success', 'La formation " ' . $formation->getNom() . ' " a bien été mise à jour !');

            return $this->redirectToRoute(
                'formation_show',
                ['formation' => $formation->getId()],
                Response::HTTP_SEE_OTHER
            );
        }

        return $this->render('formation/update.html.twig', [
            'formation_form' => $formationUpdate,

        ]);
    }

    #[Route('/{formation}/supprimer', name: 'delete', methods: ['POST'])]
    public function delete(Formation $formation, FormationRepository $formationRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $formationRepository->remove($formation, true);

            $this->addFlash('success', 'La formation " ' . $formation->getNom() . ' " a bien été supprimée !');
        } else {
            $this->addFlash('warning', 'Une erreur est survenue !');
        }


        return $this->redirectToRoute('formation_index');
    }
}
